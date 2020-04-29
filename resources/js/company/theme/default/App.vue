<template>
<v-app>
    <v-system-bar v-if="auth"
        app
        color="#000">
        <v-spacer></v-spacer>
        <v-toolbar-items v-if="$vuetify.breakpoint.mdAndUp">
            <v-btn v-for="branch in company.branches" :key="branch.id" text class="white--text" :class="activeClass == branch.id?'custom-active-class':''" :to="'/'+branch.id+'/orders'">{{branch.name}}</v-btn>
            <v-btn text class="white--text" @click="onLogout()">Logout</v-btn>
        </v-toolbar-items>
        <v-toolbar-items v-else>
            <v-btn v-for="branch in company.branches" :key="branch.id" text class="white--text" :class="activeClass == branch.id?'custom-active-class':''" :to="'/'+branch.id+'/orders'">{{branch.short_name}}</v-btn>
            <v-btn text class="white--text" @click="onLogout()">Logout</v-btn>
        </v-toolbar-items>
    </v-system-bar>
    <v-app-bar app height="100" style="" v-if="$vuetify.breakpoint.mdAndUp" :color="auth?company.header_background_color:'#000000'">
      <v-toolbar-items>
        <router-link v-if="auth" :to="'/'+activeClass+'/orders'"><img :src="auth?imageUrl+company.logo:'/company/images/card/logo.png'" height="100" width="120"></router-link>
        <router-link v-else to="/"><img :src="logo" height="100" width="120"></router-link>
      </v-toolbar-items>
        <v-spacer v-if="!auth"></v-spacer>
        <v-toolbar-items v-if="auth" class="ml-4">
            <v-btn class="col_white" text :to="'/'+activeClass+'/orders'" :color="auth?company.header_color:''">View Orders</v-btn>
            <v-btn  class="col_white" text :to="'/'+activeClass+'/past-orders'" :color="auth?company.header_color:''">Past Orders</v-btn>
            <v-btn  class="col_white" text :to="'/'+activeClass+'/add-new-card'" :color="auth?company.header_color:''">Add New</v-btn>
        </v-toolbar-items>
    </v-app-bar>
    <v-app-bar app height="60" v-else :color="auth?company.header_background_color:'#000000'">
      <v-toolbar-items>
        <router-link v-if="auth" to="orders"><img :src="logo" height="60" width="80"></router-link>
        <router-link v-else to="/"><img :src="logo" height="60" width="80"></router-link>
      </v-toolbar-items>
        <v-spacer v-if="!auth"></v-spacer>
        <v-spacer v-if="$vuetify.breakpoint.smAndDown"></v-spacer>
        <v-toolbar-items v-if="auth" class="ml-4">
            <v-btn text :to="'/'+activeClass+'/orders'" :color="auth?company.header_color:''"><v-icon>list</v-icon></v-btn>
            <v-btn text :to="'/'+activeClass+'/past-orders'" :color="auth?company.header_color:''"><v-icon>playlist_add_check</v-icon></v-btn>
            <v-btn text :to="'/'+activeClass+'/add-new-card'" :color="auth?company.header_color:''"><v-icon>queue</v-icon></v-btn>
        </v-toolbar-items>

    </v-app-bar>
    <!-- Main Contact Here -->
    <v-content>
        <router-view></router-view>
        <v-overlay :value="approvalProgress">
      <v-progress-circular indeterminate size="80" width="8" color="primary"></v-progress-circular>
    </v-overlay>
    </v-content>
    <!-- Footer Start -->
    <v-footer
      absolute
      class="font-weight-medium" :color="auth?company.footer_background_color:'#000000'">
      <v-col v-if="auth"
        class="text-center"
        cols="12" >
        <span :style="'color:'+company.footer_text_color">{{ company.footer_text }}</span>
      </v-col>
      <v-col v-else
        class="text-center"
        cols="12" style="color:#ffffff;">
        {{ new Date().getFullYear() }} — <strong>C Results Business Card</strong>
      </v-col>
    </v-footer>
    <v-btn v-if="auth"
      bottom
      color="red"
      dark
      fab
      fixed
      right
      to="add-new-card">
      <v-icon>mdi-plus</v-icon>
    </v-btn>
</v-app>
</template>
<script>
export default {
    data:()=>{
        return {
            protocol:window.location.protocol,
            hostname:window.location.hostname,
        }

    },
    computed:{
        auth(){
          return this.$store.getters.isAuthenticated
        },
        successMdl(){
            return this.$store.getters.successMdl
        },
        logo(){
            return this.$store.getters.logo
        },
        background(){
            return this.$store.getters.background
        },
        company(){
            return this.$store.getters.company
        },
        activeClass(){
            return this.$store.getters.activeClass
        },
        approvalProgress(){
            return this.$store.getters.approvalProgress
        },
        imageUrl(){
            return location.protocol+'//'+location.hostname+'/company/images/card/'
        }

    },
    methods:{
        onLogout(){
          this.$store.dispatch('logout')
        }
    },
    beforeCreate(){
        this.$store.dispatch('tryAutoLogin')
    },
    created(){
      this.$store.dispatch('getSettings');
      console.log(this.company);
    }

}
</script>
<style scoped>
    .crbc-main-content{
        background-size: cover;
    }
    .custom-active-class{
        background-color: red !important;
        color: white;
    }
    .col_white{color:#ffffff;}
</style>
