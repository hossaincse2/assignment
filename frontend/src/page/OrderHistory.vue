<template>
    <div>
        <div class="bg-purple-100 py-5">
            <div class="max-w-2xl mx-auto px-2 sm:px-6 lg:max-w-7xl lg:px-2 mb-2">
                <div class="px-4  rounded-lg">
                    <h4 class="text-3xl text-gray-700 mb-5">Order History</h4>
                </div>
            </div>
        </div>
        <div class="max-w-2xl mx-auto px-2 sm:px-6 lg:max-w-7xl lg:px-2 mb-2 mt-2">
            <div class="lg:col-span-4 md:col-span-4 sm:col-span-12">
                <label for="sort_by" class="block text-sm font-medium text-gray-700">Sort By</label>
                <select id="sort_by" @change="getOrderByFilter($event)" name="sort_by"
                        autocomplete="text"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option v-for="(sort, index) in sortOptions" :key="index" :value="sort.value">
                        {{sort.text}}
                    </option>
                </select>
            </div>

        <div v-if="orders.length > 0" class="flex flex-col bg-white shadow-lg rounded-lg overflow-hidden my-6  mx-6" v-for="order in orders" :key="order.id">
            <div class="bg-gray-200 text-gray-700 text-lg px-6 py-4">Order Number #{{order.order_no}}</div>

            <div class="flex justify-between items-center px-6 py-4">
                <div v-if="order.status == 'Pending'" class="bg-yellow-600 text-xs uppercase px-2 py-1 rounded-full border border-gray-200 text-gray-200 font-bold">{{order.status}}</div>
                <div v-else-if="order.status == 'Approved'"  class="bg-blue-600 text-xs uppercase px-2 py-1 rounded-full border border-gray-200 text-gray-200 font-bold">{{order.status}}</div>
                <div v-else-if="order.status == 'Delivered'"  class="bg-green-600 text-xs uppercase px-2 py-1 rounded-full border border-gray-200 text-gray-200 font-bold">{{order.status}}</div>
                <div v-else-if="order.status == 'Rejected'"  class="bg-red-600 text-xs uppercase px-2 py-1 rounded-full border border-gray-200 text-gray-200 font-bold">{{order.status}}</div>

                <div class="text-sm">{{format_date(order.created_at)}}</div>
            </div>

            <div class="px-6 py-4 border-t border-gray-200">
                <div class="border rounded-lg p-4 bg-gray-200">
                     <p>Customer Name: {{order.user.name}}</p>
                     <p>Total Amount: ${{order.total_amount}}</p>
                     <p>Total VAT: ${{order.total_vat}}</p>
                     <p>Net Total: ${{order.net_amount}}</p>
                 </div>
            </div>

            <div class="bg-gray-200 px-6 py-4">
                <div class="uppercase text-xs text-gray-600 font-bold">Products</div>

                <div class="flex items-center pt-3" v-if="order.order_details" v-for="order_detail in order.order_details">
                    <div class="bg-blue-700 w-12 h-12 flex justify-center items-center uppercase font-bold text-white">
                        <img  :src="BASE_PATH +'/base-url-img/'+ order_detail.product.image + '/thumbnail'"  :alt="order_detail.product.product_name"></div>
                    <div class="ml-4">
                        <p class="font-bold">{{order_detail.product.product_name}}</p>
                        <p class="text-sm text-gray-700 mt-1">{{order_detail.qty}} X ${{order_detail.price}}</p>
                    </div>
                </div>
            </div>
        </div>
            <div v-else class="flex flex-col bg-white shadow-lg rounded-lg overflow-hidden my-6  mx-6" >
                <div class="flex justify-between items-center px-6 py-4">
                     <div class="text-sm">No Order Found</div>
                </div>
            </div>
    </div>
    </div>
</template>
<script>
     import UserService from "../services/user.service";
     import moment from 'moment'
     import Config from '../config/index'
    export default {
        name: 'App',
        components: {

        },
        computed: {
            currentUser() {
                return this.$store.state.auth.user;
            },

        },
        data() {
            return {
                orders: [],
                BASE_PATH: Config.baseUrl,
                status: '',
                sortOptions : [
                    {text: 'All Order', value: ""},
                    {text: 'Pending', value: "Pending"},
                    {text: 'Approved', value: "Approved"},
                    {text: 'Delivered', value: "Delivered"},
                    {text: 'Rejected', value: "Rejected"},
                ],
            };
        },
        mounted() {
            UserService.getOrders().then(
                (response) => {
                    this.orders = response.data.orders;
                },
                (error) => {

                }
            );
        },
        methods: {
            format_date(value){
                if (value) {
                    return moment(String(value)).format('MMMM D, YYYY, h:mm:ss a')
                }
            },
            getOrderByFilter(event){
                UserService.getFilterOrders(event.target.value).then(
                    (response) => {
                        this.orders = response.data.orders;
                    },
                    (error) => {

                    }
                );
            }
        },
    }

</script>
<style scoped>
    a {
        color: #42b983;
    }
</style>
