<template>
<v-container
    class=""
    :class="!auth?'crbc-main-content':''"
    fluid>
    <v-row class="mb-12">
        <v-col md="10" offset-md="1">
            <v-alert v-if="success" type="success">
                {{successMessage}}
            </v-alert>
            <v-card>
                <v-card-title>
                    View Orders
                    <div class="flex-grow-1"></div>
                    <v-text-field
                        v-model="search"
                        append-icon="search"
                        label="Search"
                        single-line
                        hide-details
                    >
                    </v-text-field>
                </v-card-title>
                <v-data-table
                v-model="selected"
                :headers="headers"
                :items="orders"
                item-key="id"
                show-select
                :search="search">
                    <template v-slot:item.action="{ item }">                    
                        <v-tooltip top color="success">
                            <template #activator="{ on }">
                                <v-icon
                                    small
                                    class="mr-2"
                                    v-on="on"
                                    @click="orderNow(item)"
                                >
                                    done
                                </v-icon>
                            </template>
                            <span>Approve / Order Now</span>
                        </v-tooltip>
                        <v-tooltip top color="info">
                            <template #activator="{ on }">
                                <v-icon
                                    small
                                    class="mr-2"
                                    v-on="on"
                                    @click="editOrder(item)"
                                >
                                    edit
                                </v-icon>
                            </template>
                            <span>Edit</span>
                        </v-tooltip>
                        <v-tooltip top color="warning">
                            <template #activator="{ on }">
                                <v-icon
                                    small
                                    class="mr-2"
                                    v-on="on"
                                    @click="deleteOrder(item)"
                                >
                                    delete
                                </v-icon>
                            </template>
                            <span>Delete</span>
                        </v-tooltip>
                    </template>
                </v-data-table>
            </v-card>
        </v-col>
    </v-row>

</v-container>
</template>

<script>
export default {
 data () {
      return {
        search: '',
        selected: [],
        headers: [
          {
            text: 'Name',
            align: 'left',
            value: 'name',
          },
          { text: 'Title', value: 'title' },
          { text: 'Mobile', value: 'mobile' },
          { text: 'Order At', value: 'created_at' },
          { text: 'Email', value: 'email' },
          { text: 'Actions', value: 'action', sortable: false }
        ],
        editedIndex:-1,
        editedOrder:{},
        defaultOrder:{}
      }
    },
    computed:{
        auth(){
            return this.$store.getters.isAuthenticated;
        },
        orders(){
            return this.$store.getters.currentOrders
        },
        activeClass(){
            return this.$store.getters.activeClass
        },
        success(){
            return this.$store.getters.success
        },
        successMessage(){
            return this.$store.getters.successMessage
        },
    },
    methods:{
        downloadOrder(item){
            if(item.proof != ""){
                window.open(location.protocol+'//'+location.hostname+'/pdf/'+item.proof)
            }else{
                this.$store.dispatch('downloadProof', item.email)
            }
        },
        deleteOrder(item){
            const index = this.orders.indexOf(item)
            var btn = confirm('Are you sure you want to delete this order?')
            if(btn == true){
                var formData = new FormData();
                formData.append('id', item.id)
                this.$store.dispatch('deleteOrder', formData)
                this.orders.splice(index, 1)
            }
        },
        editOrder(item){
            this.$store.dispatch('setPackage', item.package_id)
            if(item.image != "")
                this.$store.dispatch('setImageUrl',item.image)

            this.$router.push('order/'+item.id+'/edit-card')
        },
        orderNow(item){            
            var email =item.email
            this.$store.dispatch('approvalProgress',true)
            this.$store.dispatch('approveOrder',email)
            // this.$store.dispatch('downloadProof',email)
        },
        getNewOrder(){
            this.$store.dispatch('setActiveClass')
            this.$store.dispatch('getOrders', this.activeClass)
        }
    },
    watch:{
    '$route'(to, from){
            this.getNewOrder()
        }
    },
    created(){
        this.$store.dispatch('setActiveClass')
        this.$store.dispatch('getOrders', this.activeClass)
        console.log("test")
    }
  }

</script>

