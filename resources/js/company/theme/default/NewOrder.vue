<template>
<v-container
    fluid>
       <v-row>
           <v-col md="10" offset-md="1">
               <v-alert v-if="success" type="success">
                    {{successMessage}}
                </v-alert>
               <v-row>
           <v-col md="6">
               <v-card>
                   <v-card-title>Enter your information</v-card-title>
                   <v-divider></v-divider>
                   <v-form ref="form">
                    <v-col class="py-0">
                       <v-text-field label="Name" type="text" v-model="name" :rules="nameRules"></v-text-field>
                   </v-col>
                    <v-col class="py-0">
                       <v-text-field label="Title" type="text" v-model="title" :rules="titleRules"></v-text-field>
                   </v-col>
                    <v-col class="py-0">
                       <v-text-field label="Mobile" type="text" v-model="mobile" :rules="mobileRules"></v-text-field>
                   </v-col>
                   <v-col class="py-0">
                       <v-text-field label="Direct Dial" type="text" v-model="direct_dial" :rules="ddRules"></v-text-field>
                   </v-col>
                   <v-col class="py-0">
                       <v-text-field label="Email" type="text" v-model="email" :rules="emailRules"></v-text-field>
                   </v-col>
                   <v-col class="py-0">
                       <v-select
                        :items="packages"
                        label="Select Package"
                        v-model="selectedItem"
                        item-value="id"
                        :rules="sRules"
                        >
                            <template slot="selection" slot-scope="packages">
                                {{ packages.item.details }} - {{ packages.item.price +'AUD'}}
                            </template>
                            <template slot="item" slot-scope="packages">
                                {{ packages.item.details }} - {{ packages.item.price +'AUD'}}
                            </template>
                        </v-select>
                   </v-col>

                   <v-col>
                       <v-btn color="primary" tile @click.prevent="saveCard">Save Card</v-btn>
                   </v-col>
                   </v-form>
               </v-card>
           </v-col>

            <v-col md="6">
                <v-card>
                   <v-card-title>Your card will look like this</v-card-title>
                   <v-divider></v-divider>
                   <v-row>
                       <v-col class="pa-6">
                            <v-card
                                class="mx-auto"
                                max-width="340"
                                max-height="208"
                                tile
                                color="#D0D3D4"
                                elevation="2"
                            >
                                <v-img
                                class="white--text"
                                height="325px"
                                :src="SHPreset"
                                >
                                <div class="pa-9 fill-height">
                                    <p class="display-1 red--text mb-0 font-weight-medium">{{getName}}</p>
                                    <p class="headline white--text">{{getTitle}}</p>
                                    <br><br>
                                    <p class="white--text"><span class="red--text">M:</span> {{mobile}}</p>
                                    <p class="white--text"><span class="red--text">D:</span> {{direct_dial}}</p>
                                    <p class="white--text"><span class="red--text">E:</span> {{getEmail}}</p>
                                </div>

                                </v-img>

                                <p class="px-9 py-8 subtitle-2"><span class="red--text">A:</span> 242 Leach Hwy, Myaree WA 6154 <span class="red--text">| W:</span> summithomes.com.au</p>

                            </v-card>
                            <v-btn @click="downloadPdf" color="primary" tile>Download Proof</v-btn>
                            <v-btn @click="approveOrder" color="primary" tile>Approve</v-btn>
                       </v-col>
                   </v-row>
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
            name:'',
            nameRules: [
                    v => !!v || 'Name is required'
                ],
            email: '',
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
            title: '',
            titleRules: [
                    v => !!v || 'Job title is required'
                ],
            mobile: '',
            mobileRules: [
                    v => !!v || 'Mobile is required'
                ],
            direct_dial: '',
            ddRules: [
                    v => !!v || 'Direct dial is required'
                ],
            selectedItem:null,
            sRules: [
                    v => !!v || 'Package is required'
            ],
        }
    },
    computed:{
        getName(){
            return this.name.toUpperCase()
        },
        getTitle(){
            return this.title.toUpperCase()
        },
        getEmail(){
            return this.email.toLowerCase()
        },
        packages(){
            return this.$store.getters.packages
        },
        success(){
            return this.$store.getters.success
        },
        successMessage(){
            return this.$store.getters.successMessage
        },
        SHPreset(){
            return this.$store.getters.SHPreset
        }
    },
    methods:{
        downloadPdf(){
            var email =this.email
            this.$store.dispatch('downloadProof',email)
        },
        approveOrder(){
            var email =this.email
            this.$store.dispatch('approvalProgress',true)
            this.$store.dispatch('approveOrder',email)
        },
        saveCard(){
            if (!this.$refs.form.validate()) {
                return
            }
            var formData = new FormData();
            formData.append('name', this.name)
            formData.append('email', this.email)
            formData.append('mobile', this.mobile)
            formData.append('dd', this.direct_dial)
            formData.append('title', this.title)
            formData.append('package_id', this.selectedItem)
            this.$store.dispatch('saveCard', formData)
        }
    },
    created(){
        this.$store.dispatch('getPackages')
    }
}
</script>
<style scoped>
.container.fill-height{
    align-items: unset;
}
</style>
