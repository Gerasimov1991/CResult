<template>
<v-app>
    <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.smAndDown"
      right
      app
    >
      <v-list>
        <v-list-item
          v-for="item in items"
          :key="item.title"
          link
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title @click.prevent="item.action">{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar app height="100" v-if="$vuetify.breakpoint.mdAndUp" style="background:#000000;">
      <v-toolbar-items>
        <router-link v-if="auth" to="/backend/users"><img v-bind:src="logo" height="100" width="120"></router-link>
        <router-link v-else to="/backend"><img v-bind:src="logo" height="100" width="120"></router-link>
      </v-toolbar-items>
        <v-spacer v-if="!auth"></v-spacer>
        <v-toolbar-items v-if="auth" class="ml-4">
            <v-btn text to="/backend/users" style="color:#ffffff;">Users</v-btn>           
            <v-btn text to="/backend/companies" style="color:#ffffff;">Companies</v-btn>
            <v-btn text to="/backend/branches" style="color:#ffffff;">Branches</v-btn>
            <v-btn text to="/backend/company" style="color:#ffffff;">Setting</v-btn>
            <v-btn text to="/backend/packages" style="color:#ffffff;">Packages</v-btn> 
            <v-btn text to="/backend/pastorders" style="color:#ffffff;">Orders</v-btn>            
        </v-toolbar-items>
        <div class="logoutposition" v-if="auth">
          <button @click="onLogout()" class="btn_logout"  style="color:#ffffff;">Logout</button>
        </div>
    </v-app-bar>
    <v-app-bar app height="60" v-else style="background:#000000;">
      <v-toolbar-items>
        <router-link v-if="auth" to="/backend/users"><img :src="logo_sm" height="60" width="120"></router-link>
        <router-link v-else to="/backend"><img :src="logo_sm" height="60" width="120"></router-link>
      </v-toolbar-items>
        <v-spacer v-if="$vuetify.breakpoint.smAndDown"></v-spacer>
        <v-toolbar-items v-if="auth">
            <v-btn text min-width="54px" @click.stop="drawer = !drawer"><v-icon>view_list</v-icon></v-btn>
        </v-toolbar-items>

    </v-app-bar>
    <!-- Main Contact Here -->
    <v-content>
        <v-snackbar
        v-model="alert"
        :color="alertType"
        top
        >
        {{ message }}
        </v-snackbar>
        <router-view></router-view>
    </v-content>
    <!-- Footer Start -->
    <v-footer
      absolute
      class="font-weight-medium"
    >
      <v-col
        class="text-center"
        cols="12"
      >
        {{ new Date().getFullYear() }} — <strong>C Results Business Card</strong>
      </v-col>
    </v-footer>
</v-app>
</template>
<script>
import {required, email, minLength} from 'vuelidate/lib/validators'
export default {
    data(){
        return {
            drawer:false,
            name:'',
            email:'',
            password:'',
            protocol:location.protocol,
            hostname:location.hostname,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            items: [
                    { title: 'Company', icon: 'location_city', action:this.companies},
                    { title: 'Branches', icon: 'home_work', action:this.branches},
                    { title: 'Packages', icon: 'pages', action:this.packages},
                    { title: 'Users', icon: 'people', action:this.users },
                    { title: 'Settings', icon: 'settings_applications', action:this.settings},                    
                    { title: 'Orders', icon: 'settings_applications', action:this.pastorders},
                    { title: 'Logout', icon: 'power_settings_new', action:this.logout}
                ],
        }
    },
    computed:{
        auth(){
          return this.$store.getters.isAuthenticated
        },
        logo(){
            return this.$store.getters.logo
        },
        logo_sm(){
            return this.$store.getters.logo_sm
        },
        background(){
            return this.$store.getters.background
        },
        message(){
            return this.$store.getters.message
        },
        alert(){
            return this.$store.getters.alert
        },
        alertType(){
            return this.$store.getters.alertType
        }
    },
    methods:{
        onLogout(){
          this.$store.dispatch('logout')
        },
        companies(){
            this.$router.replace('/backend/companies')
            this.drawer = false
        },
        packages(){
            this.$router.replace('/backend/packages')
            this.drawer = false
        },
        users(){
            this.$router.replace('/backend/users')
            this.drawer = false
        },
        branches(){
            this.$router.replace('/backend/branches')
            this.drawer = false
        },
        settings(){
            this.$router.replace('/backend/company')
            this.drawer = false
        },
        vieworders(){
            this.$router.replace('/backend/vieworders')
            this.drawer = false
        },
        pastorders(){
            this.$router.replace('/backend/pastorders')
            this.drawer = false
        },
        logout(){
            this.$store.dispatch('logout')
        }
    },
    beforeCreate(){
         this.$store.dispatch('getSettings')
    },
    created(){
      this.$store.dispatch('tryAutoLogin')
    }

}
</script>
<style lang="scss" scoped>
    .crbc-main-content{
        background-size: cover;
    }
  .btn_logout{font-weight: 600;    
  }
  .logoutposition{position: absolute;right:30px;}
</style>
