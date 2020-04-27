import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/dist/vuetify.min.css'
import Vue from 'vue'
import Vuetify from 'vuetify'
import Vuelidate from 'vuelidate'

import router from './router'
import store from './store'

import App from './theme/default/App.vue'

Vue.use(Vuetify)
Vue.use(Vuelidate)

const vuetify = new Vuetify()


new Vue({
    el:'.crbcadmin',
    vuetify,
    router,
    store,
    render: h => h(App)
})
