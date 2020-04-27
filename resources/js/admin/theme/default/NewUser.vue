<template>
  <v-container class :class="!auth?'crbc-main-content':''" fluid>
    <v-row class="mb-12">
      <v-col md="8" offset-md="2">
            <v-alert v-if="success" type="success">
              {{successMessage}}
            </v-alert>
            <v-card>
              <v-card-title>New User</v-card-title>
              <v-divider></v-divider>
              <v-col>
                <v-form>
                    <input type="hidden" name="_token" :value="csrf">
                  <v-text-field
                    label="Name"
                    color="#ed1c24"
                    v-model="name"
                    :error-messages="nameErrors"
                    @input="$v.name.$touch()"
                  ></v-text-field>
                  <v-text-field
                    label="Email Address"
                    color="#ed1c24"
                    v-model="email"
                    :error-messages="emailErrors"
                    @input="$v.email.$touch()"
                    ></v-text-field>
                  <v-text-field
                    label="Password"
                    type="password"
                    v-model="password"
                    color="#ed1c24"
                    :error-messages="passwordErrors"
                    @input="$v.password.$touch()"
                    ></v-text-field>

                  <v-btn @click.prevent="addUser">Save</v-btn>
                </v-form>
              </v-col>
            </v-card>

      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import {required, email, minLength} from 'vuelidate/lib/validators'
export default {
  data(){
      return {
          name:'',
          email:'',
          password:'',
          csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
  },
  validations:{
        email:{
            required,
            email
        },
        password:{
            required,
            min:minLength(8)
        },
        name:{
            required
        }
    },
  computed: {
    auth() {
      return this.$store.getters.isAuthenticated;
    },
    company(){
        return this.$store.getters.company
    },
    emailErrors(){
        const errors = []
        if(!this.$v.email.$dirty) return errors
        !this.$v.email.email && errors.push('Must be a valide email.')
        !this.$v.email.required && errors.push('The email field is required.')
        return errors
    },
    passwordErrors(){
        const errors = []
        if(!this.$v.password.$dirty) return errors
        !this.$v.password.required && errors.push('Password is required.')
        !this.$v.password.min && errors.push('Password length muct be 8')
        return errors
    },
    nameErrors(){
        const errors = []
        if(!this.$v.name.$dirty) return errors
        !this.$v.name.required && errors.push('Name is required.')
        return errors
    },
    success(){
        return this.$store.getters.success
    },
    successMessage(){
        return this.$store.getters.successMessage
    },
  },
  methods:{
      addUser(){
          var formData = new FormData()
          formData.append('name', this.name)
          formData.append('email', this.email)
          formData.append('password', this.password)
          this.$store.dispatch('addUser', formData)
          this.name=''
          this.password=''
          this.email=''
      }
  }
};
</script>

<style scoped>
    .custom-file-input{
        width: 100%;
        margin-bottom: 25px;
    }
</style>
