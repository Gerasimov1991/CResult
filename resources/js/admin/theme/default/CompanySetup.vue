<template>
  <v-container class :class="!auth?'crbc-main-content':''" fluid>
    <v-row class="mb-12">
      <v-col md="8" offset-md="2">
        <v-row>
          <v-col cols="12">
            <v-card>
              <v-card-title>Website Setting</v-card-title>
              <v-divider></v-divider>
              <v-col>
                <v-form enctype="multipart/form-data" id="settingFrm">
                    <!-- <input type="hidden" name="_token" :value="csrf"> -->
                    <v-row>
                    <v-col cols="12" md="6">
                        <v-text-field  label="Company Name"  v-model="settings.name"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field  label="Company Email"  v-model="settings.email"></v-text-field>
                    </v-col>
                    </v-row>
                    <v-row>
                    <v-col cols="12" md="6">
                        <v-text-field  label="Company Mobile"  v-model="settings.mobile"></v-text-field>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-text-field  label="Company Telephone"  v-model="settings.telephone"></v-text-field>
                    </v-col>
                    </v-row>
                    <v-row>
                    <v-col cols="12">
                        <v-text-field  label="Company Website"  v-model="settings.website"></v-text-field>
                    </v-col>
                    <v-col>
                    <v-textarea  label="Company Address"  v-model="settings.address"></v-textarea>
                    </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" md="4">
                  <label>Logo</label>
                  <v-divider></v-divider>
                  <input type="file" accept="image/*" @change="onLogoChange" ref="fileInput" class="custom-file-input mt-2">
                  <v-img v-if="logoUrl != null"
                        :src="logoUrl"
                        :lazy-src="logoUrl"
                        aspect-ratio="1"
                        class="grey lighten-2"
                        max-width="150"
                        max-height="150"
                    ></v-img>
                    <v-img v-else
                        :src="logo"
                        :lazy-src="logo"
                        aspect-ratio="1"
                        class="grey lighten-2"
                        max-width="150"
                        max-height="150"
                    ></v-img>
                        </v-col>
                        <v-col cols="12" md="4">
                <label>Mobile Logo</label>
                <v-divider></v-divider>
                  <input type="file" accept="image/*" @change="onLogoSmChange" ref="fileInputSM" class="custom-file-input mt-2">
                  <v-img v-if="logoSMUrl != null"
                        :src="logoSMUrl"
                        :lazy-src="logoSMUrl"
                        aspect-ratio="1"
                        class="grey lighten-2"
                        max-width="150"
                        max-height="150"
                    ></v-img>
                    <v-img v-else
                        :src="logo_sm"
                        :lazy-src="logo_sm"
                        aspect-ratio="1"
                        class="grey lighten-2"
                        max-width="150"
                        max-height="150"
                    ></v-img>
                        </v-col>
                        <v-col cols="12" md="4">
                  <label>Background</label>
                  <v-divider></v-divider>
                  <input type="file" accept="image/*" ref="fileInputb" @change="onBackgroundChange" class="custom-file-input mt-2">
                   <v-img v-if="backgroundUrl != null"
                        :src="backgroundUrl"
                        :lazy-src="backgroundUrl"
                        aspect-ratio="1"
                        class="grey lighten-2"
                        max-width="150"
                        max-height="150"
                    ></v-img>
                   <v-img v-else
                        :src="background"
                        :lazy-src="background"
                        aspect-ratio="1"
                        class="grey lighten-2"
                        max-width="150"
                        max-height="150"
                    ></v-img>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                                <v-btn @click.prevent="updateSettings" color="primary" tile>Save</v-btn>
                        </v-col>
                    </v-row>
                </v-form>
              </v-col>
            </v-card>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data:()=>{
      return {
          csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          logoUrl:null,
          backgroundUrl:null,
          logoSMUrl:null
      }
  },
  computed: {
    auth() {
      return this.$store.getters.isAuthenticated;
    },
    settings(){
        return this.$store.getters.settings
    },
    logo(){
        return this.$store.getters.logo
    },
    logo_sm(){
        return this.$store.getters.logo_sm
    },
    background(){
        return this.$store.getters.background
    }
  },
  methods:{
        onLogoChange(e) {
            const file = this.$refs.fileInput.files[0]
            this.logoUrl = URL.createObjectURL(file);
        },
        onLogoSmChange(e) {
            const file = this.$refs.fileInputSM.files[0]
            this.logoSMUrl = URL.createObjectURL(file);
        },
        onBackgroundChange(e){
            const file = this.$refs.fileInputb.files[0]
            this.backgroundUrl = URL.createObjectURL(file);
        },
        updateSettings(){
            var file = this.$refs.fileInput.files[0]
            var background = this.$refs.fileInputb.files[0]
            var logoSM = this.$refs.fileInputSM.files[0]
            var formData = new FormData();
            formData.append('logo', file)
            formData.append('background', background)
            formData.append('name', this.settings.name)
            formData.append('address', this.settings.address)
            formData.append('email', this.settings.email)
            formData.append('mobile', this.settings.mobile)
            formData.append('telephone', this.settings.telephone)
            formData.append('website', this.settings.website)
            formData.append('logo_sm', logoSM)
            this.$store.dispatch("updateSetttings", formData)
        }
  },
  created() {
    this.$store.dispatch("getSettings");
  }
};
</script>

<style scoped>
    .custom-file-input{
        width: 100%;
        margin-bottom: 25px;
    }
</style>
