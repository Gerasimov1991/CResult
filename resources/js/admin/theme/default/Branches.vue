<template>
<v-container
    :class="!auth?'crbc-main-content':''"
    fluid>
    <v-row class="mb-12">
        <v-col md="10" offset-md="1">
            <v-card>
                <div style="margin-top: 10px;text-align: right;">
                    <v-btn text @click="editItem(-1)"><i class="fas fa-building"></i>Add Branch</v-btn>
                </div>
            <v-card-title>
            Branches
            <div class="flex-grow-1"></div>
            <v-text-field
                v-model="search"
                append-icon="search"
                label="Search"
                single-line
                hide-details
            ></v-text-field>
            </v-card-title>
            <v-data-table
            v-model="selected"
            :headers="headers"
            :items="branches"
            item-key="name"
            show-select
            :search="search">
                <template v-slot:item.preset_image="{ item }">
                    <v-img :src="getImage(item.preset_image)" width="40" height="40"></v-img>
                </template>
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
<v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">{{dialogTitle}}</span>
        </v-card-title>
         <v-card-actions>
          <div class="flex-grow-1"></div>
          <v-btn color="black darken-1" text @click="close">Close</v-btn>
          <v-btn color="red darken-1" text @click.prevent="updateBranch">Save</v-btn>
        </v-card-actions>
        <v-card-text>
          <v-container>
            <v-form ref="form" enctype="multipart/form-data">
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
                    >
                    </v-text-field>
                    <v-text-field
                    label="Website"
                    color="#ed1c24"
                    v-model="editedItem.website"
                    required
                    ></v-text-field>

                    <v-select
                    :items="companies"
                    label="Select Company"
                    v-model="selectedItem"
                    item-value="id"
                    item-text="name"
                    :rules="sRules"
                    >

                    </v-select>
                    <v-checkbox
                        v-model="editedItem.upload_avatar"
                        label="User will able to upload picture?"
                    ></v-checkbox>
                <v-row>
                    <v-col cols="12" md="6">
                <label>Preset Image</label>
                <v-divider></v-divider>
                <input type="file" accept="image/*" @change="onFileChange" ref="fileInput" class="custom-file-input">
                <v-img v-if="!imageUrl" :src="getImage(editedItem.preset_image)" width="120" height="120" style="margin-top:10px"></v-img>
                <v-img v-else :src="imageUrl" width="120" height="120" style="margin-top:10px"></v-img>
                    </v-col>
                    <v-col cols="12" md="6">
                       <label>Front Image</label>
                        <v-divider></v-divider>
                        <input type="file" accept="image/*" @change="onFrontImageChange" ref="fileFrontImage" class="custom-file-input">
                        <v-img v-if="!frontImageUrl" :src="getFrontImage(editedItem.front_image)" width="120" height="120" style="margin-top:10px"></v-img>
                        <v-img v-else :src="frontImageUrl" width="120" height="120" style="margin-top:10px"></v-img>
                    </v-col>
                </v-row>
            </v-form>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
       
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
      <v-icon>mdi-plus</v-icon>
    </v-btn>
</v-container>
</template>

<script>
export default {
 data () {
      return {
        dialog:false,
        dialogTitle:'Add Branch',
        search: '',
        imageUrl:null,
        frontImageUrl:null,
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        selected: [],
        headers: [
          {
            text: 'Name',
            align: 'left',
            value: 'name',
          },
          { text: 'Address', value: 'address' },
          { text: 'Company', value:'company.name'},
          { text: 'Preset Image', value:'preset_image', sortable:false },
          { text: 'Created At', value: 'created_at' },
          { text: 'Actions', value: 'action', sortable: false }
        ],
        editedIndex: -1,
        editedItem: {
            id:0,
            name: '',
            address: '',
            website:'',
            preset_image:'',
            front_image:'',
            company_id:'',
            created_at:'',
            updated_at:''
        },
        defaultItem: {
            id:0,
            name: '',
            address: '',
            website:'',
            preset_image:'',
            front_image:'',
            company_id:'',
            created_at:'',
            updated_at:''
        },
        nameRules: [
            v => !!v || 'Name is required',
        ],
        addressRules: [
            v => !!v || 'Price is required and valid number',
        ],
        selectedItem:'',
        sRules: [
                v => !!v || 'Package is required'
        ]
      }
    },
    computed:{
        auth(){
            return this.$store.getters.isAuthenticated;
        },
        branches(){
            return this.$store.getters.branches
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
        editItem (item) {
            if(item < 0)
            {
                this.dialogTitle = 'Add Branch'
            }
            else
            {
                this.dialogTitle = 'Edit branch information'
            }
            
            this.editedIndex = this.branches.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.selectedItem = this.editedItem.company_id
            this.dialog = true
        },
        deleteItem (item) {
            const index = this.branches.indexOf(item)
            var btn = confirm('Are you sure you want to delete this package?')
            if(btn == true){
                var formData = new FormData();
                formData.append('id', item.id)
                this.$store.dispatch('deletePackage', formData)
                this.branches.splice(index, 1)
            }
        },
        onFileChange(e){
            const file = this.$refs.fileInput.files[0]
            this.imageUrl = URL.createObjectURL(file)

        },
        onFrontImageChange(e){
            const file = this.$refs.fileFrontImage.files[0]
            this.frontImageUrl = URL.createObjectURL(file)
        },
        updateBranch(){
            if (!this.$refs.form.validate()) {
                return
            }
            const file = this.$refs.fileInput.files[0]
            const frontImage = this.$refs.fileFrontImage.files[0]
            var formData = new FormData()
            formData.append('id', this.editedItem.id)
            formData.append('name', this.editedItem.name)
            formData.append('address', this.editedItem.address)
            formData.append('website', this.editedItem.website)
            formData.append('image', file)
            formData.append('front_image', frontImage)
            formData.append('upload_avatar', this.editedItem.upload_avatar)
            formData.append('company_id', this.selectedItem)
            this.$store.dispatch('updateBranch', formData)
            this.dialog =false
            setTimeout(()=>{
                this.editedItem = Object.assign({}, this.defaultItem)
                this.dialogTitle= 'Add Branch'
                this.imageUrl = ''
                this.frontImageUrl = ''
                this.$refs.form.reset()
            },200)

        },
        close () {
            this.dialog = false
            setTimeout(() => {
            this.editedItem = Object.assign({}, this.defaultItem)
            this.dialogTitle= 'Add Branch'
            this.imageUrl = ''
            this.$refs.form.reset()
            this.editedIndex = -1
            }, 200)
        },
        getImage(image){
            if(image)
                return location.protocol+'//'+location.hostname+'/company/images/card/'+image
        },
        getFrontImage(image){
            if(image)
                return location.protocol+'//'+location.hostname+'/company/images/card/'+image
        }

    },
    created(){
        this.$store.dispatch('getCompanies')
        this.$store.dispatch('getbranches')
    }
  }

</script>

