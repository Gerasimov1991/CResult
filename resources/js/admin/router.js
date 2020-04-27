import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from './theme/default/Home.vue'
import Users from './theme/default/Users.vue'
import CompanySetup from './theme/default/CompanySetup.vue'
import NewUser from './theme/default/NewUser.vue'
import Packages from './theme/default/Packages.vue'
import Companies from './theme/default/Companies.vue'
import Branches from './theme/default/Branches.vue'
import PastOrder from './theme/default/PastOrder.vue'
import ViewOrder from './theme/default/ViewOrder.vue'

import store from './store'

Vue.use(VueRouter)

const routes = [
    {path: '/backend', component: Home},
    {
        path: '/backend/users',
        component: Users,
        beforeEnter(to,from,next){
            if(store.state.token && store.state.isAdmin){
                next()
            }else{
                next('/backend')
            }
        }
    },
    {
        path: '/backend/companies',
        component: Companies,
        beforeEnter(to,from,next){
            if(store.state.token && store.state.isAdmin){
                next()
            }else{
                next('/backend')
            }
        }
    },
    {
        path: '/backend/branches',
        component: Branches,
        beforeEnter(to,from,next){
            if(store.state.token && store.state.isAdmin){
                next()
            }else{
                next('/backend')
            }
        }
    },
    {
        path: '/backend/user/add-new',
        component: NewUser,
        beforeEnter(to,from,next){
            if(store.state.token && store.state.isAdmin){
                next()
            }else{
                next('/backend')
            }
        }
    },
    {
        path: '/backend/company',
        component: CompanySetup,
        beforeEnter(to,from,next){
            if(store.state.token && store.state.isAdmin){
                next()
            }else{
                next('/backend')
            }
        }
    },    
    {
        path: '/backend/packages',
        component: Packages,
        beforeEnter(to,from,next){
            if(store.state.token && store.state.isAdmin){
                next()
            }else{
                next('/backend')
            }
        }
    },
    {
        path: '/backend/pastorders',
        component: PastOrder,
        beforeEnter(to,from,next){
            if(store.state.token && store.state.isAdmin){
                next()
            }else{
                next('/backend')
            }
        }
    },
    {
        path: '/backend/vieworders',
        component: ViewOrder,
        beforeEnter(to,from,next){
            if(store.state.token && store.state.isAdmin){
                next()
            }else{
                next('/backend')
            }
        }
    }
]

export default new VueRouter({mode:'history', routes})
