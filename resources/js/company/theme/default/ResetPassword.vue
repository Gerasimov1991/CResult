<template>
<v-container
    class="fill-height"
    :class="!isUserLoggedIn?'crbc-main-content':''"
    fluid>
<v-row
    align="center"
    justify="center">
    <v-col>
    <v-card
        max-width="450"
        class="mx-auto pa-4"
        tile
        elevation="4"
        style="background-color:rgba(255,255,255,0.9);">
        <v-card-title>Reset Password</v-card-title>
        <v-col cols="12" class="py-0">
            <v-text-field
            label="Email Address"
            color="#ed1c24"
            v-model="email"
            :error-messages="emailErrors"
            required
            @input="$v.email.$touch()"
            ></v-text-field>
        </v-col>
        <router-link to="/" style="text-decoration:none;" class="ml-3 red--text">Back to Sign In</router-link>
        <v-col cols="12">
        <v-btn
            width="100%" color="#ed1c24" class="white--text" :disabled="this.$v.$invalid? true:false">Send Reset Link</v-btn>
        </v-col>
    </v-card>
    </v-col>
</v-row>
</v-container>
</template>

<script>
import {required, email} from 'vuelidate/lib/validators'
export default {
    data:()=>({
        email:''
    }),
    validations:{
        email:{
            required,
            email
        }
    },
    computed:{
         emailErrors(){
            const errors = []
            if(!this.$v.email.$dirty) return errors
            !this.$v.email.email && errors.push('Must be a valide email.')
            !this.$v.email.required && errors.push('The email field is required.')
            return errors
        },
    }
}
</script>
