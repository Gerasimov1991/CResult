<template>
<v-container
    fluid>
<v-row>
 <v-col md="10" offset-md="1">
    <v-alert v-if="success" type="success">
        {{successMessage}}
    </v-alert>
    <v-row>
        <v-col cols="12" md="8">
            <v-card>
                <v-card-title>Enter your information</v-card-title>
                <v-divider></v-divider>
                <v-col cols="12" class="py-0">
                <v-form ref="form">
                    <v-row>
                        <v-col md="6">
                            <v-text-field label="Name" type="text" v-model="name" :rules="nameRules"></v-text-field>
                        </v-col>
                        <v-col md="6">
                            <v-text-field label="Title" type="text" v-model="title" :rules="titleRules"></v-text-field>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col md="4">
                            <v-text-field label="Mobile" type="text" v-model="mobile" :rules="mobileRules"></v-text-field>
                        </v-col>
                        <v-col md="4">
                            <v-text-field label="Direct Dial" type="text" v-model="direct_dial" :rules="ddRules"></v-text-field>
                        </v-col>
                        <v-col md="4">
                            <v-text-field label="Email" type="text" v-model="email" :rules="emailRules"></v-text-field>
                        </v-col>
                    </v-row>


                <v-row>
                    <v-col md="2" v-if="cardImage">
                            <v-text-field label="IS" v-model="cardImageSize" type="number"></v-text-field>
                        </v-col>
                        <v-col md="2" v-if="cardImage">
                            <v-text-field label="Top" v-model="cardImageTop" type="number"></v-text-field>

                        </v-col>
                        <v-col md="2" v-if="cardImage">
                            <v-text-field label="Right" v-model="cardImageRight" type="number"></v-text-field>
                        </v-col>
                        <!-- <v-col md="2">
                            <v-text-field type="number" v-model="footerFontSize" label="Footer font size"></v-text-field>
                        </v-col> -->
                <v-col class="py-0" :md="cardImage?4:12">
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
                </v-row>
                <v-col>
                    <v-btn color="primary" tile @click.prevent="saveCard">Save Card</v-btn>
                </v-col>
                </v-form>
                </v-col>
            </v-card>
        </v-col>

        <v-col cols="12" md="4">
            <v-card class="mb-8">
                <v-card-title>Your card will look like this</v-card-title>
                <v-divider></v-divider>
                <v-row>
                    <v-col headline>
                        <v-card
                            class="mx-auto mb-4"
                            width="340"
                            height="208"
                            tile
                            color="#D0D3D4"
                            elevation="2"
                            :style="'font-family:'+selectedFont"
                        >
                            <v-img
                            class="white--text"
                            height="160px"
                            :src="preset"
                            >
                            <div class="fill-height pa-4">
                                <p :style="'margin:0px;margin-top:'+marginTop+'px;padding:0px;font-size:'+nameFontSize+'px;font-weight:'+nameFontWeight+';color:'+mainColor+';'">{{getName}}</p>
                                <p :style="'margin-top:0px;margin-left:0px;margin-right:0px;margin-bottom:'+marginBottom+'px;padding:0px;font-size:'+titleFontSize+'px;font-weight:'+titleFontWeight+';color:'+subColor+';'">{{getTitle}}</p>
                                <p :style="'margin:0px;padding:0px;color:'+subColor+';font-size:'+fontSize+'px;'"><span :style="'color:'+mainColor+';'">M:</span> {{mobile}}</p>
                                <p :style="'margin:0px;padding:0px;color:'+subColor+';font-size:'+fontSize+'px;'"><span :style="'color:'+mainColor+';'">D:</span> {{direct_dial}}</p>
                                <p :style="'margin:0px;padding:0px;color:'+subColor+';font-size:'+fontSize+'px;'"><span :style="'color:'+mainColor+';'">E:</span> {{getEmail}}</p>
                            </div>
                            </v-img>
                            <v-list-item-avatar
                                v-if="cardImage"
                                tile
                                :size="cardImageSize"
                                color="white"
                                :style="'position:absolute;top:'+cardImageTop+'px;right:'+cardImageRight+'px'"
                            >
                            <v-img :src="imageUrl" height="auto"></v-img>
                            </v-list-item-avatar>
                            <p class="pl-4 pt-2" :style="'font-size:'+footerFontSize+'px;'"><span :style="'color:'+mainColor+';'">A:</span> 242 Leach Hwy, Myaree WA 6154 <span :style="'color:'+mainColor+';'">| W:</span> summithomes.com.au</p>
                        </v-card>
                    </v-col>

                </v-row>
                <v-row>
                    <v-col>                           
                        <v-btn style="width:100%;" @click="approveOrder" color="primary" tile>Approve</v-btn>
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
            fontSize:12,
            name:'',
            marginTop:0,
            marginBottom:30,
            footerFontSize:12,
            nameFontSize:16,
            nameFontWeight:'bold',
            fontWeights:['normal','bold','lighter'],
            mainColor:'#ff0000',
            subColor:'#ffffff',
            nameRules: [
                    v => !!v || 'Name is required'
                ],
            email: '',
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
            ],
            title: '',
            titleFontSize:14,
            titleFontWeight:'bold',
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
            imageUrl: '',
            selectedItem:null,
            sRules: [
                    v => !!v || 'Package is required'
            ],
            cardImage:false,
            branch_id:null,
            cardImageSize:60,
            cardImageRight:15,
            cardImageTop:12,
            selectedFont:'AlegreyaSansSC-Black'
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
        },
        frontImg(){
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
            return url+branch.front_image
        },
        fonts(){
            return this.$store.getters.fonts
        }
    },
    components:{
    },
    methods:{
        downloadPdf(){
            var email =this.email
            this.$store.dispatch('downloadPdf',email)
        },
        approveOrder(){
            var email =this.email
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
            formData.append('name', this.name)
            formData.append('email', this.email)
            formData.append('mobile', this.mobile)
            formData.append('dd', this.direct_dial)
            formData.append('title', this.title)
            formData.append('name_font_size', this.nameFontSize)
            formData.append('name_font_weight', this.nameFontWeight)
            formData.append('title_font_size', this.titleFontSize)
            formData.append('title_font_weight', this.titleFontWeight)
            formData.append('main_font_size', this.fontSize)
            formData.append('main_color', this.mainColor)
            formData.append('sub_color', this.subColor)
            formData.append('font_name', this.selectedFont)
            formData.append('image_size', this.cardImageSize)
            formData.append('image_top_margin', this.cardImageTop)
            formData.append('image_right_margin', this.cardImageRight)
            formData.append('margin_top', this.marginTop)
            formData.append('margin_bottom', this.marginBottom)
            formData.append('footer_font_size', this.footerFontSize)

            if(this.cardImage)
                formData.append('image', file)
            formData.append('branch_id', this.branch_id)
            formData.append('package_id', this.selectedItem)

            console.log(formData)
            this.$store.dispatch('saveCardWithPhoto', formData)
        }
    },
    created(){
        this.$store.dispatch('getPackages')
        this.$store.dispatch('getFonts')
    }

}
</script>

<style scoped>
@import '/company/css/fonts.css';
.container.fill-height{
    align-items: unset;
}
</style>
