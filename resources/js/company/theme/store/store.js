import Vue from 'vue'
import Vuex from 'vuex'
import axios from '../../axios-auth'
import router from '../../router'

Vue.use(Vuex)

export default new Vuex.Store({
    state:{
       token: null,
       email: null,
       invalidLogin: false,
       company:{
        name:'',
        address:'',
        branches:[
            {name:'', address:''},
            {name:'', address:''}
            ]
        },
        settings:{},
        card:{},
        pack:null,
        imageUrl:null,
        packages:[],
        success:false,
        successMdl:false,
        currentOrders:[],
        pastOrders:[],
        activeClass:null,
        successMessage:'Success',
        approvalProgress:false,
        cardImage:false,
        fonts:[]
    },
    getters:{
        isAuthenticated (state) {
            return state.token !== null
        },
        invalidLogin(state){
            return state.invalidLogin == true
        },
        company(state){
            return state.company
        },
        settings(state){
            return state.settings
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
        currentOrders(state){
            return state.currentOrders
        },
        pastOrders(state){
            return state.pastOrders
        },
        successMessage(state){
            return state.successMessage
        },
        activeClass(state){
            return state.activeClass
        },
        card(state){
            return state.card
        },
        pack(state){
            return state.pack
        },
        imageUrl(state){
            return state.imageUrl
        },
        approvalProgress(state){
            return state.approvalProgress
        },
        cardImage(state){
            return state.cardImage
        },
        fonts(state){
            return state.fonts
        }
    },
    mutations:{
        loggedIn(state, userData){
            state.token = userData.token
            state.email = userData.email
        },
        logout(state){
            state.token = null
            state.email = null
        },
        invalidLogin(state){
            state.invalidLogin = true
        },
        clearInvalidLogin(state){
            state.invalidLogin = false
        },
        settings(state, settings){
            state.settings = settings
        },
        currentOrders(state, orders){
            state.currentOrders = orders
        },
        pastOrders(state,orders){
            state.pastOrders = orders
        },
        successMessage(state,message){
            state.successMessage = message
        },
        activeClass(state,value){
            state.activeClass = value
        },
        card(state,card){
            state.card = card
        },
        pack(state, pack){
            state.pack = pack
        },
        imageUrl(state, image){
            state.imageUrl = image
        },
        approvalProgress(state,bool){
            state.approvalProgress = bool
        },
        company(state,company){
            state.company = company
        },
        cardImage(state,bool){
            state.cardImage = bool
        },
        fonts(state,fonts){
            state.fonts = fonts
        }
    },
    actions:{
        setLogoutTimer({commit}, expirationTime){
            setTimeout(()=>{
                commit('logout')
            }, expirationTime * 1000)
        },
        alertRemove({commit}){
            setTimeout(()=>{
                commit('clearInvalidLogin')
            },3000)
        },
        tryAutoLogin({commit,dispatch}){
            const token = localStorage.getItem('token')
            if(!token){
                return
            }
            const expirationDate = localStorage.getItem('expires_in')
            const now = new Date()
            if(now.getTime() > new Date(expirationDate).getTime()){
                dispatch('logout')
                return
            }
            let company = JSON.parse(localStorage.getItem('company'))
            commit('company', company)
            const email = localStorage.getItem('email')

            commit('loggedIn',{
                token: token,
                email: email
            })

            router.replace('/'+company.branches[0].id+'/orders')
        },
        getCompany({commit,dispatch,state}){
            axios.get('company?token='+state.token)
            .then(response=>{
                localStorage.removeItem('company')
                localStorage.setItem('company',JSON.stringify(response.data.company))
                commit('company', response.data.company)
            })
            .catch(error=>{
                console.log(error)
            })
        },
        login({commit, dispatch}, userData){
            axios.post('/login',
            {
                email: userData.email,
                password: userData.password
            })
            .then(function(response){
                console.log(response.data);
                const now = new Date();
                const expirationDate = new Date(now.getTime() + response.data.expires_in * 1000)
                localStorage.setItem('token', response.data.access_token);
                localStorage.setItem('email', response.data.email);
                localStorage.setItem('expires_in', expirationDate);
                const settingsJSON = localStorage.getItem('settings')
                const settings = JSON.parse(settingsJSON)
                commit('settings', settings)
                commit('loggedIn', {
                    token: response.data.access_token,
                    email: response.data.email
                })
                dispatch('setLogoutTimer', response.data.expires_in)
                dispatch('getCompany')
                let company = JSON.parse(localStorage.getItem('company'))
                router.replace('/'+company.branches[0].id+'/orders')
            })
            .catch(function(error){

                if(error.response.status == 401){
                    commit('invalidLogin')
                    dispatch('alertRemove')
                }
            })
        },
        logout({commit}){
            commit('logout')
            localStorage.removeItem('token')
            localStorage.removeItem('email')
            localStorage.removeItem('expires_in')
            router.replace('/')
        },
        getSettings({commit,dispatch,state}){
            axios.get('settings')
                .then(response =>{
                    commit('settings', response.data.settings)
                    localStorage.removeItem('settings')
                    localStorage.setItem('settings', JSON.stringify(response.data.settings))
                })
                .catch(error=>{

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
        saveCardWithPhoto({commit,dispatch,state}, formData){
            axios.post('save-card-with-photo?token='+state.token,formData)
                .then(response =>{
                    commit('successMessage', 'Your card has been saved.')
                    state.success = true
                    setTimeout(function(){
                        state.success = false
                    },3000)
                })
                .catch(error => {
                    console.log(error.response)
                })
        },
        saveCard({commit,dispatch,state}, formData){
            axios.post('save-card?token='+state.token,formData)
                .then(response =>{                    
                    commit('successMessage', 'Your card has been saved.')
                    state.success = true
                    setTimeout(function(){
                        state.success = false
                    },3000)
                })
                .catch(error => {
                    console.log(error.response)
                })
        },
        downloadPdf({commit,dispatch,state},email){
            axios.get('pdf?token='+state.token,{
                params:{
                    email:email
                }
            })
                .then(response=>{
                    window.open(location.protocol+'//'+location.hostname+'/pdf/'+response.data.name);
                })
                .catch(error=>{
                    console.log(error.response)
                })
        },
        downloadProof({commit,dispatch,state},email){
            axios.get('download-proof?token='+state.token,{
                params:{
                    email:email
                }
            })
                .then(response=>{
                    window.open(location.protocol+'//'+location.hostname+'/pdf/'+response.data.name);
                })
                .catch(error=>{
                    console.log(error.response)
                })
        },
        approveOrder({commit, dispatch,state},email){
            axios.get('approve-order?token='+state.token,{
                params:{
                    email:email
                }
            })
            .then(response=>{
                commit('successMessage', 'Thanks, your order has been sent.')
                state.success = true
                commit('approvalProgress',false)
                setTimeout(function(){
                    state.success = false
                },6000)
            })
            .catch(error=>{
                commit('approvalProgress',false)
                console.log(error.response)
            })
        },
        deleteOrder({commit,dispatch,state},formData){
            axios.post('delete-order?token='+state.token,formData)
                .then(response=>{
                    commit('successMessage', 'Order has been deleted.')
                })
                .catch(error=>{
                    console.log(error.response)
                })
        },
        getOrders({commit,dispatch,state},branch_id){
            axios.get('get-orders?token='+state.token,{params:{branch_id:branch_id}})
                .then(response =>{
                    commit('currentOrders', response.data.orders)
                })
                .catch(error=>{
                    console.log(error.response)
                })
        },
        getSRPastOrders({commit,dispatch,state}){
            axios.get('get-sr-past-orders?token='+state.token)
                .then(response=>{
                    commit('pastOrders', response.data.orders)
                })
                .catch(error=>{
                    console.log(error.response)
                })
        },
        getSHPastOrders({commit,dispatch,state}){
            axios.get('get-sh-past-orders?token='+state.token)
                .then(response=>{
                    commit('pastOrders', response.data.orders)
                })
                .catch(error=>{
                    console.log(error.response)
                })
        },
        setActiveClass({commit,dispatch,state}){
            var str = router.currentRoute.path
            var parts = str.split('/')
            commit('activeClass', parts[1])
        },
        getCard({commit,dispatch,state},id){
            axios.get('get-card?token='+state.token,{params:{id:id}})
                .then(response=>{
                    commit('card',response.data.card)
                })
                .catch(error=>{
                    console.log(error.response)
                })
        },
        getFonts({commit,dispatch,state}){
            axios.get('fonts?token='+state.token)
            .then(response=>{
                console.log(response)
                commit('fonts', response.data.fonts)
            })
        },
        setPackage({commit},package_id){
            commit('pack', package_id)
        },
        setImageUrl({commit}, image){
            let url = location.protocol+'//'+location.hostname+'/company/images/card/'+image
            commit('imageUrl', url)
        },
        approvalProgress({commit},bool){
            commit('approvalProgress',bool)
        }
    }
})


