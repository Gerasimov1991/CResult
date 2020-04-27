<template>
<v-container
    class="fill-height"
    :class="!auth?'crbc-main-content':''"
    v-bind:style="{ 'background-image': 'url(' + background + ')' }"
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
            <v-card-title>Sign In</v-card-title>
            <v-alert v-if="invalidLogin" type="error" dense dismissible>
                Invalide Login
            </v-alert>
            <v-col cols="12" class="py-0">
                <v-text-field
                label="Email Address"
                color="#ed1c24"
                v-model="email"
                :error-messages="emailErrors"
                required
                @input="$v.email.$touch()"
                >
                </v-text-field>
            </v-col>

            <v-col cols="12" class="py-0">
                <v-text-field
                label="Password"
                type="password"
                color="#ed1c24"
                v-model="password"
                :error-messages="passwordErrors"
                required
                @input="$v.password.$touch()"
                ></v-text-field>
            </v-col>
            <router-link to="/reset-password" style="text-decoration:none;" class="ml-3 red--text">Forgot your password?</router-link>
            <v-col cols="12">
            <v-btn
                width="100%" color="#ed1c24" class="white--text" :disabled="this.$v.$invalid? true:false" @click="login()">Login</v-btn>
            </v-col>
        </v-card>
        </v-col>
    </v-row>
</v-container>
</template>
<script>
import {required, email, minLength} from 'vuelidate/lib/validators'
import axios from './../../axios-auth'
export default {
    data(){
        return {
            email: '',
            password: ''
        }
    },
    methods:{
        login(){
            const userData = {
                email: this.email,
                password: this.password
            }
            this.$store.dispatch('login', userData)
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
        passwordErrors(){
            const errors = []
            if(!this.$v.password.$dirty) return errors
            !this.$v.password.required && errors.push('Password is required.')
            !this.$v.password.min && errors.push('Password length muct be 8')
            return errors
        },
        auth(){
            return this.$store.getters.isAuthenticated
        },
        invalidLogin(){
            return this.$store.getters.invalidLogin
        },
        background(){
            return this.$store.getters.background
        }
    },
    created(){
        this.$store.dispatch('setActiveClass')
    }

}
</script>
