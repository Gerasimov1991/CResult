import Vue from 'vue'
import Vuex from 'vuex'
import axios from './axios-auth'
import router from './router'
Vue.use(Vuex)

export default new Vuex.Store({
    state:{
        token: null,
        email: null,
        isAdmin: null,
        settings:{},
        users:[],
        packages:[],
        success:false,
        successMdl:false,
        companies:[],
        branches:[],
        message:'',
        alert:false,
        alertType:'green',
        currentOrders:[],
        pastOrders:[],
        successMessage:'Success',
    },
    getters:{
        isAuthenticated (state) {
            return state.token !== null && state.isAdmin == 1
        },
        settings(state){
            return state.settings
        },
        users(state){
            return state.users
        },
        packages(state){
            return state.packages
        },
        success(state){
            return state.success
        },
        successMdl(state){
            return state.successMdl
        },
        logo(state){
            return location.protocol+'//'+location.hostname+'/company/images/card/'+state.settings.logo
        },
        logo_sm(state){
            return location.protocol+'//'+location.hostname+'/company/images/card/'+state.settings.logo_sm
        },
        background(state){
            return location.protocol+'//'+location.hostname+'/company/images/card/'+state.settings.background
        },
        companies(state){
            return state.companies
        },
        message(state){
            return state.message
        },
        alert(state){
            return state.alert
        },
        alertType(state){
            return state.alertType
        },
        branches(state){
          return state.branches
        },
        currentOrders(state){
            return state.currentOrders
        },
        pastOrders(state){
            return state.pastOrders
        },
        successMessage(state){
            return state.successMessage
        },
    },
    mutations:{
        loggedIn(state, userData){
            state.token = userData.token
            state.email = userData.email
            state.isAdmin = userData.isAdmin
        },
        logout(state){
            state.token = null
            state.email = null
            state.isAdmin = null
        },
        settings(state, settings){
            state.settings = settings
        },
        companies(state,companies){
            state.companies = companies
        },
        alert(state,bool){
            state.alert=bool
        },
        message(state,message){
            state.message = message
        },
        alertType(state,alertType){
            state.alertType = alertType
        },
        branches(state,branches){
            state.branches=branches
        },
        currentOrders(state, orders){
            state.currentOrders = orders
        },
        pastOrders(state,orders){
            state.pastOrders = orders
        },
        successMessage(state,message){
            state.successMessage = message
        }
    },
    actions:{
        setLogoutTimer({commit}, expirationTime){
            setTimeout(()=>{
                commit('logout')
            }, expirationTime * 1000)
        },
        tryAutoLogin({commit,dispatch}){
            const token = localStorage.getItem('token')
            if(!token){
                dispatch('logout')
                return
            }
            const expirationDate = localStorage.getItem('expires_in')
            const now = new Date()
            if(now.getTime() > new Date(expirationDate).getTime()){
                dispatch('logout')
                return
            }
            const email = localStorage.getItem('email')
            const isAdmin = localStorage.getItem('is_admin')
            commit('loggedIn',{
                token: token,
                email: email,
                isAdmin:isAdmin
            })
            router.replace('/backend/users')
        },
        login({commit, dispatch}, userData){
            axios.post('/login',
            {
                email: userData.email,
                password: userData.password
            })
            .then(function(response){
                const now = new Date();
                const expirationDate = new Date(now.getTime() + response.data.expires_in * 1000)
                localStorage.setItem('token', response.data.access_token);
                localStorage.setItem('email', response.data.email);
                localStorage.setItem('expires_in', expirationDate);
                localStorage.setItem('is_admin', response.data.is_admin);
                const settingsJSON = localStorage.getItem('settings')
                const settings = JSON.parse(settingsJSON)
                commit('settings', settings)
                commit('loggedIn', {
                    token: response.data.access_token,
                    email: response.data.email,
                    isAdmin: response.data.is_admin
                })
                dispatch('setLogoutTimer', response.data.expires_in)

                router.replace('/backend/users')
            })
            .then(function(error){
               // console.log(error)
            })
        },
        logout({commit}){
            commit('logout')
            localStorage.removeItem('token')
            localStorage.removeItem('email')
            localStorage.removeItem('expires_in')
            localStorage.removeItem('is_admin')
            router.replace('/backend')
        },
        getSettings({commit, dispatch,state}){
            if(localStorage.getItem('settings')){
                const settingsJSON = localStorage.getItem('settings')
                const settings = JSON.parse(settingsJSON)
                commit('settings', settings)
                return
            }
            axios.get('settings')
                .then(function(response){
                    commit('settings', response.data.settings)
                    localStorage.setItem('settings', JSON.stringify(response.data.settings))
                })
                .catch(function(error){
                    console.log(error.response)
                })
        },
        updateSetttings({commit,dispatch,state},formData){

            axios.post('update-settings?token='+state.token,formData)
                .then(function(response){
                    localStorage.removeItem('settings')
                    localStorage.setItem('settings', JSON.stringify(response.data.settings))
                    dispatch('setAlert', response.data.message)
                })
                .catch(function(error){
                    console.log(error.response)
                })
        },
        getUsers({commit,dispatch,state}){
            axios.get('users?token='+state.token)
                .then(function(response){
                    state.users = response.data.users
                })
                .catch(function(error){
                    console.log(error.response)
                })
        },
        updateUser({commit,dispatch,state}, formDate){
            axios.post('update-user?token='+state.token, formDate)
                .then(function(response){
                    dispatch('getUsers')
                    commit('alertType', 'green')
                    dispatch('setAlert', response.data.message)
                })
                .catch(function(error){
                    console.log(error.response)
                })
        },
        deleteUser({commit,dispatch,state}, formData){
            axios.post('delete-user?token='+state.token,formData)
                .then(function(response){
                    state.success = true
                    setTimeout(function(){
                        state.success = false
                    },3000)
                })
                .catch(function(error){
                    console.log(error.response)
                })
        },
        getPackages({commit,dispatch,state}){
            axios.get('packages?token='+state.token)
                .then(function(response){
                    state.packages = response.data.packages
                })
                .catch(function(error){
                    console.log(error.response)
                })
        },
        updatePackage({commit,dispatch,state}, formData){
            axios.post('update-package?token'+state.token,formData)
                .then(function(response){
                    dispatch('getPackages')
                    commit('alertType', 'green')
                    dispatch('setAlert', response.data.message)
                })
                .catch(function(error){
                    console.log(error.response)
                })
        },
        deletePackage({commit,dispatch,state},formData){
            axios.post('delete-package?token='+state.token,formData)
                .then(response =>{
                    state.success = true
                    setTimeout(function(){
                        state.success = false
                    },3000)
                })
                .catch(error =>{

                })
        },
        addPackage({commit,dispatch,state},formData){
            axios.post('add-package?token='+state.token, formData)
                .then(response =>{
                    dispatch('getPackages')
                })
                .catch(error =>{

                })
        },
        setAlert({commit,dispatch,state},message){
            commit('message', message)
            commit('alert', true)
            setTimeout(()=>{
                commit('alert', false)
            },4000)

        },
        getCompanies({commit,dispatch,state}){
            axios.get('companies')
            .then(response=>{
                commit('companies', response.data.companies)
            })
            .catch(error=>{
                console.log(error.response)
            })
        },
        updateCompany({commit,dispatch,state},formData){
            axios.post('update-company?token='+state.token, formData)
                .then(response=>{
                    commit('alertType', 'green')
                    dispatch('setAlert', response.data.message)
                    dispatch('getCompanies');
                })
                .catch(error=>{
                    console.log(error)
                })
        },
        getbranches({commit,dispatch,state}){
            axios.get('branches?token='+state.token)
                .then(response=>{
                    commit('branches',response.data.branches)
                })
                .catch(error=>{
                    console.log(error)
                })
        },
        updateBranch({commit,dispatch,state},formData){
            axios.post('update-branch?token='+state.token, formData)
                .then(response=>{
                    commit('alertType', 'green')
                    dispatch('setAlert', response.data.message)
                    dispatch('getbranches')
                })
                .catch(error=>{
                    console.log(error)
                })
        },
        getOrders({commit,dispatch,state},branch_id){
            axios.get('get-orders?token='+state.token,{params:{branch_id:0}})
                .then(response =>{
                    commit('currentOrders', response.data.orders)
                })
                .catch(error=>{
                    console.log(error.response)
                })
        },
        getPastOrders({commit,dispatch,state}){
            axios.get('get-past-orders?token='+state.token)
                .then(response=>{
                    commit('pastOrders', response.data.orders)
                })
                .catch(error=>{
                    console.log(error.response)
                })
        },
        addUser({commit,dispatch,state}, formData){
            axios.post('adduser?token='+state.token,formData)
                .then(response =>{                    
                    commit('successMessage', 'User account has been created.')
                    state.success = true
                    setTimeout(function(){
                        state.success = false
                    },3000)
                })
                .catch(error => {
                    console.log(error.response)
                })
        },
    }

})
