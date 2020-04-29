<template>
<v-container
    fluid>
<v-row>
 <v-col md="10" offset-md="1">
            <v-alert v-if="success" type="success">
                {{successMessage}}
            </v-alert>
               <v-row>
           <v-col cols="12" md="6">
               <v-card>
                   <v-card-title>Edit your information</v-card-title>
                   <v-divider></v-divider>
                   <v-form ref="form">
                    <v-col class="py-0">
                       <v-text-field label="Name" type="text" v-model="card.name" :rules="nameRules"></v-text-field>
                   </v-col>
                    <v-col class="py-0">
                       <v-text-field label="Title" type="text" v-model="card.title" :rules="titleRules"></v-text-field>
                   </v-col>
                    <v-col class="py-0">
                       <v-text-field label="Mobile" type="text" v-model="card.mobile" :rules="mobileRules"></v-text-field>
                   </v-col>
                   <v-col class="py-0">
                       <v-text-field label="Direct Dial" type="text" v-model="card.direct_dial" :rules="ddRules"></v-text-field>
                   </v-col>
                   <v-col class="py-0">
                       <v-text-field label="Email" type="text" v-model="card.email" :rules="emailRules"></v-text-field>
                   </v-col>
                   <v-col class="py-0" v-if="cardImage">
                       <label class="mb-2" style="width:100%">Upload Photo</label>
                       <input type="file" ref="fileInput" accept="image/*" style="width:100%;" class="mb-4" @change="onFileChange"/>
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
                       <v-btn color="#ff0000" tile @click.prevent="saveCard"><span style="color:white;">Save Card</span></v-btn>
                   </v-col>
                   </v-form>
               </v-card>
           </v-col>

            <v-col cols="12" md="6">
                <v-card class="mb-8">
                   <v-card-title>Your card will look like this</v-card-title>
                   <v-divider></v-divider>
                   <v-row>
                       <v-col class="pa-6" headline>
                            <v-card
                                class="mx-auto"
                                max-width="100%"
                                tile
                                color="#D0D3D4"
                                elevation="2"
                            >
                                <v-img
                                class="white--text"
                                height="325px"
                                :src="'/company/images/vcb.png'"
                                >
                                <div class="fill-height" :class="$vuetify.breakpoint.mdAndUp? 'pa-9':'pa-4'">
                                    <p class="red--text mb-0 font-weight-medium" :class="$vuetify.breakpoint.mdAndUp? 'display-1':'body-1'">{{card.name}}</p>
                                    <p class="headline white--text" :class="$vuetify.breakpoint.mdAndUp? 'headline':'body-1'">{{card.title}}</p>
                                    <br><br>
                                    <p class="white--text"><span class="red--text">M:</span> {{card.mobile}}</p>
                                    <p class="white--text"><span class="red--text">D:</span> {{card.direct_dial}}</p>
                                    <p class="white--text"><span class="red--text">E:</span> {{card.email}}</p>
                                </div>
                                </v-img>
                                <v-list-item-avatar
                                    v-if="cardImage"
                                    tile
                                    :size="$vuetify.breakpoint.mdAndUp ? '135':'60'"
                                    color="white"
                                    :class="$vuetify.breakpoint.mdAndUp ? 'card-image':'card-image-sm'"
                                >
                                <v-img :src="imageUrl" height="auto"></v-img>
                                </v-list-item-avatar>
                                <p class="subtitle-2" :class="$vuetify.breakpoint.mdAndUp? 'pa-9':'pa-4'"><span class="red--text">A:</span> 242 Leach Hwy, Myaree WA 6154 <span class="red--text">| W:</span> summithomes.com.au</p>

                            </v-card>
                           
                       </v-col>
                   </v-row>
                    <v-row>
                       <v-col>

                            <v-card
                                class="mx-auto mb-4"
                                max-width="100%"
                                height="auto"
                                tile
                                color="#D0D3D4"
                                elevation="2"
                            >
                            <v-img
                                class="white--text"
                                max-width="100%"
                                height="auto"
                                
                                :src="preset"
                                ></v-img>

                                </v-card>                               
                       </v-col>
                   </v-row>
                   <v-row>
                        <v-col>
                           <v-btn @click="approveOrder" color="#ff0000" tile> <span style="color:white">Approve</span></v-btn>
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
    data(){
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
            imageUrl: this.$store.getters.imageUrl,
            selectedItem:this.$store.getters.pack,
            sRules: [
                    v => !!v || 'Package is required'
            ],
            cardImage:false,
            branch_id:null
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
        card(){
            return this.$store.getters.card
        },
        activeClass(){
            return this.$store.getters.activeClass
        },
        preset(){
            let url = location.protocol+'//'+location.hostname+'/company/images/card/';
            let company = JSON.parse(localStorage.getItem('company'))
            var items = company.branches;
            var branch = {}
            var targetItem = this.activeClass
            Object.keys(items,targetItem).forEach(key => {
                const item = items[key]
                if(item.id == targetItem)
                    branch  = item
            })
            if(branch.upload_avatar == 1){
                this.cardImage = true
            }else{
                this.cardImage = false
            }
            this.branch_id = branch.id
            return url+branch.preset_image
        }
    },
    components:{
    },
    methods:{
        downloadPdf(){
            var email =this.card.email
            this.$store.dispatch('downloadPdf',email)
        },
        approveOrder(){
            var email =this.card.email
            this.$store.dispatch('approvalProgress',true)
            this.$store.dispatch('approveOrder',email)
        },
        onFileChange(){
            const file = this.$refs.fileInput.files[0]
            this.imageUrl = URL.createObjectURL(file);
        },
        saveCard(){
            if (!this.$refs.form.validate()) {
                return
            }
            if(this.cardImage)
                var file = this.$refs.fileInput.files[0]

            var formData = new FormData();
            formData.append('name', this.card.name)
            formData.append('email', this.card.email)
            formData.append('mobile', this.card.mobile)
            formData.append('dd', this.card.direct_dial)
            formData.append('title', this.card.title)
            if(this.cardImage)
                formData.append('image', file)

            formData.append('branch_id', this.branch_id)
            formData.append('package_id', this.selectedItem)
            this.$store.dispatch('saveCardWithPhoto', formData)
        }
    },
    created(){
        this.$store.dispatch('getPackages')
        this.$store.dispatch('getCard',this.$route.params.id)
    }

}
</script>

<style scoped>
.card-image{
    position: absolute;
    top: 36px;
    right: 36px;
}

.card-image-sm{
    position: absolute;
    top: 16px;
    right: 16px;
}

.container.fill-height{
    align-items: unset;
}
</style>
