<template>
<v-container
    :class="!auth?'crbc-main-content':''"
    fluid>
    <v-row class="mb-12">
        <v-col md="10" offset-md="1">
            <v-card>
                <div style="margin-top: 10px;text-align: right;">
                    <v-btn text @click="editItem(-1)"><i class="fas fa-building"></i>Add Package</v-btn>
                </div>
            <v-card-title>
                Packages
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
            :items="packages"
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
        <v-card-text>
          <v-container>
            <v-form ref="form">
                <input type="hidden" name="_token" :value="csrf">
                  <v-text-field
                    label="Package Details"
                    color="#ed1c24"
                    v-model="editedItem.details"
                    :rules="nameRules"
                    required
                  ></v-text-field>
                  <v-text-field
                    label="Cost"
                    color="#ed1c24"
                    v-model="editedItem.price"
                    :rules="priceRules"
                    required
                    ></v-text-field>

                </v-form>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <div class="flex-grow-1"></div>
          <v-btn color="black darken-1" text @click="close">Close</v-btn>
          <v-btn color="red darken-1" text @click.prevent="updatePackage">Save</v-btn>
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
      <v-icon>mdi-plus</v-icon>
    </v-btn>
</v-container>
</template>

<script>
export default {
 data () {
      return {
        dialogTitle:'Add Package',
        dialog:false,
        search: '',
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        selected: [],
        headers: [
          {
            text: 'Details',
            align: 'left',
            value: 'details',
          },
          { text: 'Price', value: 'price' },
          { text: 'Created At', value: 'created_at' },
          { text: 'Actions', value: 'action', sortable: false }
        ],
        editedIndex: -1,
        editedItem: {
            id:0,
            details: '',
            price: 0.0,
            created_at:'',
            updated_at:''
        },
        defaultItem: {
            id:0,
            details: '',
            price: '',
            created_at:'',
            updated_at:''
        },
        nameRules: [
            v => !!v || 'Name is required',
        ],
        priceRules: [
            v => !!v || 'Price is required and valid number',
        ],
      }
    },
    computed:{
        auth(){
            return this.$store.getters.isAuthenticated;
        },
        packages(){
            return this.$store.getters.packages
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
            this.editedIndex = this.packages.indexOf(item)
            this.editedItem = Object.assign({}, item)
            if(item < 0)
            {
                this.dialogTitle = 'Add Package'
            }
            else
            {
                this.dialogTitle = 'Edit Package'
            }
            
            this.dialog = true
        },
        updatePackage(){
            if (!this.$refs.form.validate()) {
                return
            }
            var formData = new FormData()
            formData.append('id', this.editedItem.id)
            formData.append('details', this.editedItem.details)
            formData.append('price', this.editedItem.price)
            this.$store.dispatch('updatePackage', formData)
            this.dialog=false
            setTimeout(()=>{
                this.editedItem = Object.assign({}, this.defaultItem)
                this.dialogTitle= 'Add Package'
                this.$refs.form.reset()
            },200)
        },
        close () {
            this.dialog = false
            setTimeout(() => {
            this.editedItem = Object.assign({}, this.defaultItem)
            this.dialogTitle= 'Add Package'
            this.$refs.form.reset()
            this.editedIndex = -1
            }, 200)
        },

    },
    created(){
        this.$store.dispatch('getPackages')
    }
  }

</script>

