<template>
<v-container
    :class="!auth?'crbc-main-content':''"
    fluid>
    <v-row class="mb-12">
        <v-col md="10" offset-md="1">
            <v-card>
                <div style="margin-top: 10px;text-align: right;">
                    <v-btn text to="/backend/user/add-new"><i class="fas fa-user-plus"></i>Add Users</v-btn>
                </div>
                <v-card-title>
                    Users
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
                    :items="users"
                    item-key="id"
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
<v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">{{dialogTitle}}</span>
        </v-card-title>
        <v-card-actions>
          <div class="flex-grow-1"></div>
          <v-btn color="black darken-1" text @click="close">Close</v-btn>
          <v-btn color="red darken-1" text @click.prevent="updateUser">Save</v-btn>
        </v-card-actions>
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
                    label="Email Address"
                    color="#ed1c24"
                    v-model="editedItem.email"
                    :rules="emailRules"
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
                        v-if="dialogTitle != 'Add User'"
                        v-model="checkbox"
                        label="Change password"
                    ></v-checkbox>
                    <v-text-field v-if="checkbox"
                    label="Password"
                    type="password"
                    v-model="editedItem.password"
                    color="#ed1c24"
                    ></v-text-field>
                  <v-text-field v-if="dialogTitle == 'Add User'"
                    label="Password"
                    type="password"
                    v-model="editedItem.password"
                    color="#ed1c24"
                    ></v-text-field>
                </v-form>
          </v-container>
          <small>all are required field</small>
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
        checkbox:false,
        dialog:false,
        dialogTitle:'Add User',
        search: '',
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        selected: [],
        selectedItem:'',
        headers: [
          {
            text: 'Name',
            align: 'left',
            value: 'name',
          },
          { text: 'Email', value: 'email' },
          { text: 'Created At', value: 'created_at' },
          { text: 'Actions', value: 'action', sortable: false }
        ],
        editedIndex: -1,
        editedItem: {
            id:0,
            name: '',
            email: '',
            password: '',
            company_id:'',
            created_at:'',
            updated_at:'',
            email_verified_at:'',
            is_admin:0
        },
        defaultItem: {
            id:0,
            name: '',
            email: '',
            password: '',
            company_id:'',
            created_at:'',
            updated_at:'',
            email_verified_at:'',
            is_admin:0
        },
        nameRules: [
            v => !!v || 'Name is required',
        ],
        emailRules: [
            v => !!v || 'E-mail is required',
            v => /.+@.+/.test(v) || 'E-mail must be valid',
        ],
        sRules: [
                v => !!v || 'Package is required'
        ]
      }
    },
    computed:{
        auth(){
            return this.$store.getters.isAuthenticated;
        },
        users(){
            return this.$store.getters.users
        },
        companies(){
            return this.$store.getters.companies
        },
        logo(){
            return this.$store.getters.logo
        }
    },
    methods:{
        editItem (item) {
            this.editedIndex = this.users.indexOf(item)
            this.editedItem = Object.assign(this.editedItem, item)
            this.dialogTitle= 'Edit User'
            this.selectedItem = this.editedItem.company_id
            this.dialog = true
        },
        deleteItem (item) {
            const index = this.users.indexOf(item)
            var btn = confirm('Are you sure you want to delete this user?')
            if(btn == true){
                var formData = new FormData();
                formData.append('id', item.id)
                this.$store.dispatch('deleteUser', formData)
                this.users.splice(index, 1)
            }
        },
        updateUser(){
            if (!this.$refs.form.validate()) {
                return
            }
            var formData = new FormData()
            formData.append('id', this.editedItem.id)
            formData.append('name', this.editedItem.name)
            formData.append('email', this.editedItem.email)
            formData.append('password', this.editedItem.password)
            formData.append('company_id', this.selectedItem)
            this.$store.dispatch('updateUser', formData)
            this.dialog =false
            setTimeout(()=>{
                this.editedItem = Object.assign({}, this.defaultItem)
                this.dialogTitle= 'Add User'
                this.$refs.form.reset()
            },200)
        },
        close () {
            this.dialog = false
            setTimeout(() => {
            this.editedItem = Object.assign({}, this.defaultItem)
            this.dialogTitle= 'Add User'
            this.$refs.form.reset()
            this.editedIndex = -1
            }, 200)
        }

    },
    created(){
        this.$store.dispatch('getUsers')
        this.$store.dispatch('getCompanies')
    }
  }

</script>

