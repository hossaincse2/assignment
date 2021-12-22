<template>
    <div>
        <div class="bg-purple-100 py-5">
            <div class="max-w-2xl mx-auto px-2 sm:px-6 lg:max-w-7xl mb-2">
                <div class="rounded-lg">
                    <h4 class="text-3xl text-gray-700 mb-5">Place order</h4>
                </div>
            </div>
        </div>
        <div :class="isCard ? '' : ''" class="container mx-auto p-6 grid grid-cols-2 row-gap-12 lg:grid-cols-10 lg:col-gap-10 lg:pt-12">
            <div class="col-span-1 lg:col-span-5 pb-5">
                <div class="py-2">
                    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg">
                        <div class="flex flex-row py-2 px-2">
                            <h2 class="text-3xl font-semibold">Order </h2> &nbsp;
                            <h2 class="text-3xl text-green-400 font-semibold"> Information</h2>
                        </div>
                        <div class="md:flex">
                            <form action="" @submit.prevent="placeOrder">
                                <div class="w-full p-4 px-5 py-5">
                                    <div class="flex flex-row pt-2 text-xs pt-6 pb-5"> <span class="font-bold">Information</span> <small class="text-gray-400 ml-1">></small> <span class="text-gray-400 ml-1">Shopping</span> <small class="text-gray-400 ml-1">></small> <span class="text-gray-400 ml-1">Order</span> </div>
                                    <span>Customer Information</span>
                                    <div class="relative pb-5">
                                        <input readonly type="text" :value="currentUser.user.email"   class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="E-mail">
                                        <input type="text" name="contact_no" v-model="order.contact_no" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Phone Number*">
                                        <input readonly type="text" name="email"  :value="currentUser.user.name" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Full Name*">

                                    </div>
                                    <span>Shipping Address</span>
                                    <div class="grid md:grid-cols-1 md:gap-2">
                                        <input type="text" name="shipping_address" v-model="order.shipping_address" class="border rounded h-10 w-full focus:outline-none focus:border-green-200 px-2 mt-2 text-sm" placeholder="Address*">
                                    </div>

                                    <div class="flex justify-between items-center pt-2">
                                        <router-link to="/" class="h-12 w-24 text-blue-500 text-xs font-medium">Return to home</router-link>
                                        <button type="submit" class="h-12 w-48 rounded font-medium text-xs bg-blue-500 text-white">Place Order</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-1 lg:col-span-4 order-first lg:order-last">
                <h4 class="text-3xl text-gray-700 mb-5">Order Summary</h4>
                <div class="p-10 rounded-md shadow-md bg-white">
                    <item :item="product"  />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {ref} from 'vue'

    const count = ref(0)
    import UserService from "../services/user.service";
    import Item from "../components/Item.vue";
    import {notify} from "notiwind";
    export default {
        name: 'App',
        components: {
            Item,
        },
        computed: {
            currentUser() {
                return this.$store.state.auth.user;
            },

        },
        data() {
            return {
                order:{
                    product_id:'',
                    price:'',
                    qty:1,
                    vat_amount:'',
                    shipping_address:'',
                    contact_no: this.$store.state.auth.user.user.phone,
                    shipping_method:'COD',
                    status:'Pending',
                },
                product:{},
                alertVisible: false,
                total: 0,
                isCard: false
            };
        },
        mounted() {
            UserService.getProduct(this.$route.params.id).then(
                (response) => {
                    this.product = response.data.product;
                },
            );
        },
        methods: {
            placeOrder(){
                let orderData = this.order;
                 orderData.product_id = this.product.id;
                 orderData.price = this.product.price;
                 orderData.vat_amount = this.product.vat_amt;

                UserService.placeOrder(orderData).then(
                    (data) => {
                        if(data.status){
                            notify({
                                group: "foo",
                                title: "Success",
                                text: "Place order successfully"
                            }, 2000) // 2s
                            this.$router.push("/login");
                        }else{
                            notify({
                                group: "error",
                                title: "Error",
                                text: "Place order not success"
                            }, 4000)
                        }
                    },
                    (error) => {
                        notify({
                            group: "error",
                            title: "Error",
                            text: "Something went wrong"
                        }, 4000)
                    }
                );
            }
        }
    }

</script>
<style scoped>
    a {
        color: #42b983;
    }
</style>
