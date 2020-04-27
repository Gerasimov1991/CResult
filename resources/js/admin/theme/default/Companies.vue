<template>
<v-container
    :class="!auth?'crbc-main-content':''"
    fluid>
    <v-row class="mb-12">
        <v-col md="10" offset-md="1">
            
            <v-card>
                <div style="margin-top: 10px;text-align: right;">
                    <v-btn text @click="editItem(-1)"><i class="fas fa-building"></i>Add Company</v-btn>
                </div>
                <v-card-title>
                    Companies
                    <div class="flex-grow-1"></div>
                        <v-text-field
                            v-model="search"
                            append-icon="search"
                            label="Search"
                            single-line
                            hide-details
                        >
                    </v-text-field>
                </v-card-title>
                <v-data-table
                v-model="selected"
                :headers="headers"
                :items="companies"
                item-key="name"
                show-select
                :search="search">
                    <template v-slot:item.action="{ item }">

                        <v-tooltip top color="info">
                            <template #activator="{ on }">
                            <v-icon
                                small
                                class="mr-2"
                                v-on="on"
                                @click="editItem(item)"
                            >
                                edit
                            </v-icon>
                        </template>
                    <span>Edit</span>
                    </v-tooltip>
                    <v-tooltip top color="warning">
                        <template #activator="{ on }">
                            <v-icon
                                small
                                class="mr-2"
                                v-on="on"
                                @click="deleteItem(item)"
                            >
                                delete
                            </v-icon>
                        </template>
                    <span>Delete</span>
                    </v-tooltip>
                </template>
            </v-data-table>
            </v-card>
        </v-col>
    </v-row>
<!-- Edit Dialog -->
<v-dialog v-model="dialog" persistent max-width="650px">
      <v-card>
        <v-card-title>
          <span class="headline">{{dialogTitle}}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-form ref="form">
                <input type="hidden" name="_token" :value="csrf">
                  <v-text-field
                    label="Name"
                    color="#ed1c24"
                    v-model="editedItem.name"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                  <v-text-field
                    label="Address"
                    color="#ed1c24"
                    v-model="editedItem.address"
                    :rules="addressRules"
                    required
                    ></v-text-field>
                    <v-text-field
                    label="Footer text"
                    color="#ed1c24"
                    v-model="editedItem.footer_text"
                    :rules="addressRules"
                    required
                    ></v-text-field>
                    <v-row>
                        <v-col cols="12" md="3">
                            <label>Header text</label>
                            <v-divider></v-divider>
                           <input type="color" id="headerColor" ref="headerColor" :value="editedItem.header_color"/>
                        </v-col>
                        <v-col cols="12" md="3">

                            <label>Header background</label>
                            <v-divider></v-divider>
                            <input type="color" ref="headerBackgroundColor" :value="editedItem.header_background_color"/>
                        </v-col>
                        <v-col cols="12" md="3">
                            <label>Footer text</label>
                            <v-divider></v-divider>
                            <input type="color" ref="footerColor" :value="editedItem.footer_text_color"/>
                        </v-col>
                        <v-col cols="12" md="3">
                            <label>Footer background</label>
                            <v-divider></v-divider>
                            <input type="color" ref="footerBackgroundColor" :value="editedItem.footer_background_color"/>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" md="6">
                  <label>Logo</label>
                  <v-divider></v-divider>
                  <input type="file" accept="image/*" @change="onLogoChange" ref="fileInput" class="custom-file-input mt-2">
                  <v-img v-if="editedItem.logo != null"
                        :src="editedItem.logo"
                        :lazy-src="editedItem.logo"
                        aspect-ratio="1"
                        class="grey lighten-2"
                        max-width="150"
                        max-height="150"
                    ></v-img>
                    <v-img v-else
                        :src="editedItem.logo"
                        :lazy-src="editedItem.logo"
                        aspect-ratio="1"
                        class="grey lighten-2"
                        max-width="150"
                        max-height="150"
                    ></v-img>
                        </v-col>

                        <v-col cols="12" md="6">
                  <label>Background</label>
                  <v-divider></v-divider>
                  <input type="file" accept="image/*" ref="fileInputb" @change="onBackgroundChange" class="custom-file-input mt-2">
                   <v-img v-if="editedItem.background != null"
                        :src="editedItem.background"
                        :lazy-src="editedItem.background"
                        aspect-ratio="1"
                        class="grey lighten-2"
                        max-width="150"
                        max-height="150"
                    ></v-img>
                   <v-img v-else
                        :src="editedItem.background"
                        :lazy-src="editedItem.background"
                        aspect-ratio="1"
                        class="grey lighten-2"
                        max-width="150"
                        max-height="150"
                    ></v-img>
                        </v-col>
                    </v-row>
                </v-form>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <div class="flex-grow-1"></div>
          <v-btn color="blue darken-1" text @click="close">Close</v-btn>
          <v-btn color="blue darken-1" text @click.prevent="updateCompany">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

<!-- End edit dialog -->
<v-btn v-if="auth"
      bottom
      color="red"
      dark
      fab
      fixed
      right
      @click="dialog = !dialog"
    >
      <v-icon>mdi-plus</v-icon>asdfasdfasdfasdf
    </v-btn>
</v-container>
</template>

<script>
export default {
 data () {
      return {
        dialog:false,
        dialogTitle:'Add Company',
        search: '',
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        selected: [],
        headers: [
          {
            text: 'Name',
            align: 'left',
            value: 'name',
          },
          { text: 'Address', value: 'address' },
          { text: 'Created At', value: 'created_at' },
          { text: 'Actions', value: 'action', sortable: false }
        ],
        editedIndex: -1,
        editedItem: {
            id:0,
            name: '',
            address: '',
            created_at:'',
            updated_at:'',
            logo:'',
            background:'',
            header_color:null,
            header_background_color:null,
            footer_text:'',
            footer_text_color:null,
            footer_background_color:null
        },
        defaultItem: {
            id:0,
            name: '',
            address: '',
            created_at:'',
            updated_at:'',
            logo:'',
            background:'',
            header_color:null,
            header_background_color:null,
            footer_text:'',
            footer_text_color:null,
            footer_background_color:null
        },
        nameRules: [
            v => !!v || 'Name is required',
        ],
        addressRules: [
            v => !!v || 'This field is required',
        ],

      }
    },
    computed:{
        auth(){
            return this.$store.getters.isAuthenticated;
        },
        companies(){
            return this.$store.getters.companies
        },
        success(){
            return this.$store.getters.success
        },
        successMdl(){
            return this.$store.getters.successMdl
        }
    },
    methods:{
        onLogoChange(e) {
            const file = this.$refs.fileInput.files[0]
            this.editedItem.logo = URL.createObjectURL(file);
        },
        onBackgroundChange(e){
            const file = this.$refs.fileInputb.files[0]
            this.editedItem.background = URL.createObjectURL(file);
        },
        editItem (item) {
            if(item < 0)
            {
                this.dialogTitle = 'Add Company'
            }
            else
            {
                this.dialogTitle = 'Edit Company Information'
            }
            this.editedIndex = this.companies.indexOf(item)
            this.editedItem = Object.assign({}, item)

            if(this.editedItem.logo == '' || this.editedItem.logo == null)
            {
                this.editedItem.logo = location.protocol+'//'+location.hostname+'/company/images/card/default.svg'
            }else{
                this.editedItem.logo = location.protocol+'//'+location.hostname+'/company/images/card/'+this.editedItem.logo
            }

            if(this.editedItem.background == '' || this.editedItem.background == null)
            {
                this.editedItem.background = location.protocol+'//'+location.hostname+'/company/images/card/default.svg'
            }else{
                this.editedItem.background = location.protocol+'//'+location.hostname+'/company/images/card/'+this.editedItem.background
            }
            this.dialog = true
        },
        deleteItem (item) {
            const index = this.companies.indexOf(item)
            var btn = confirm('Are you sure you want to delete this package?')
            if(btn == true){
                var formData = new FormData();
                formData.append('id', item.id)
                this.$store.dispatch('deletePackage', formData)
                this.companies.splice(index, 1)
            }
        },
        updateCompany(){
            if (!this.$refs.form.validate()) {
                return
            }
            var logo = this.$refs.fileInput.files[0]
            var background = this.$refs.fileInputb.files[0]
            var headerColor = this.$refs.headerColor.value
            var headerBackgroundColor = this.$refs.headerBackgroundColor.value
            var footer_text_color = this.$refs.footerColor.value
            var footer_background_color = this.$refs.footerBackgroundColor.value
            console.log(headerColor)

            var formData = new FormData()
            formData.append('id', this.editedItem.id)
            formData.append('name', this.editedItem.name)
            formData.append('address', this.editedItem.address)
            formData.append('footer_text', this.editedItem.footer_text)
            formData.append('logo', logo)
            formData.append('background', background)
            formData.append('header_color', headerColor)
            formData.append('header_background_color', headerBackgroundColor)
            formData.append('footer_text_color', footer_text_color)
            formData.append('footer_background_color', footer_background_color)
            this.$store.dispatch('updateCompany', formData)
            this.dialog =false
            setTimeout(()=>{
                this.editedItem = Object.assign({}, this.defaultItem)
                this.dialogTitle= 'Add Company'
                this.$refs.form.reset()
            },200)

        },
        close () {
            this.dialog = false
            setTimeout(() => {

            this.editedItem = Object.assign({}, this.defaultItem)
            this.dialogTitle= 'Add Company'
            this.$refs.form.reset()
            this.editedIndex = -1
            }, 200)
        }

    },
    created(){
        this.$store.dispatch('getCompanies')
    }
  }

</script>

