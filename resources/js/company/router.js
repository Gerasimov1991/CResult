import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './theme/store/store'
import Home from './theme/default/Home.vue'
import ResetPassword from './theme/default/ResetPassword.vue'
import PastOrder from './theme/default/PastOrders.vue'
import ViewOrder from './theme/default/ViewOrder.vue'
import AddNewWithPhoto from './theme/default/AddNewWithPhoto.vue'
import SH from './theme/default/Sh.vue'
import EditCardWithPhoto from './theme/default/EditCardWithPhoto.vue'


Vue.use(VueRouter)
const routes = [
    {
        path:'/',
        component: Home,
        beforeEnter (to, from, next){
            if(!store.state.token){
                next()
            }else{
                next('/orders')
            }
        }
    },
    {path:'/reset-password', component: ResetPassword},
    {
        path: '/:bid',
        component: SH,
        beforeEnter (to, from, next){
            if(store.state.token){
                next()
            }else{
                next('/')
            }
        },
        children:[
            {
                path: 'orders',
                component: ViewOrder,
                beforeEnter(to, from, next){
                    if(store.state.token){
                        next()
                    }else{
                        next('/')
                    }
                }
            },
            {path: 'past-orders', component: PastOrder},
            {path: 'add-new-card', component: AddNewWithPhoto},
            {path: 'order/:id/edit-card', component: EditCardWithPhoto}
        ]
    }

]

export default new VueRouter({mode:'history', routes})



