import '@mdi/font/css/materialdesignicons.css'
import Vue from 'vue'
import Vuetify from 'vuetify'
import Vuelidate from 'vuelidate'
import router from './router'
import store from './theme/store/store'
import App from './theme/default/App.vue'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify)
Vue.use(Vuelidate)
const vuetify = new Vuetify()

new Vue({
    el:'.crbc',
    vuetify,
    router,
    store,
    render: h => h(App)
})
