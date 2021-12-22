<template>
    <div>
        <div class="bg-purple-100">
            <div class="max-w-2xl mx-auto px-2 sm:px-6 lg:max-w-7xl lg:px-2 mb-2">
                <div class="px-4  rounded-lg">
                    <div class="grid md:grid-cols-12 lg:grid-cols-12 sm:grid-cols-12 gap-4  py-4">
                        <div class="sm:col-span-12 md:col-span-12 lg:col-span-8 ">
                            <label for="query" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" @input="getProductBySearch($event)" v-model="parameters.query"
                                   name="query"
                                   id="query" autocomplete="query"
                                   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"/>
                        </div>
                        <div class="lg:col-span-4 md:col-span-12 sm:col-span-12">
                            <label for="sort_by" class="block text-sm font-medium text-gray-700">Sort By</label>
                            <select id="sort_by" @change="getProductByFilter($event)" name="sort_by"
                                    v-model="parameters.sort_by"
                                    autocomplete="text"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option v-for="(sort, index) in sortOptions" :key="index" :value="sort.value">
                                    {{sort.text}}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white">
            <div class="max-w-2xl mx-auto py-5 px-4   sm:px-6 lg:max-w-7xl lg:px-8">
                <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">Products</h2>
                <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                    <div v-for="product in products" :key="product.id" class="group relative">
                        <div class="w-full min-h-80 bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-80 lg:aspect-none">
                            <img :src="BASE_PATH +'/base-url-img/'+ product.image + '/original'" :alt="product.product_name"
                                 class="w-full h-full object-center object-cover lg:w-full lg:h-full"/>
                        </div>
                        <div class="mt-4 flex justify-between">
                            <div>
                                <h3 class="text-sm text-gray-700">
                                    <a href="">
                                        <span aria-hidden="true" class="absolute inset-0"/>
                                        {{ product.product_name }}
                                    </a>
                                </h3>
                                <!--                                <p class="mt-1 text-sm text-gray-500">{{ product.description }}</p>-->
                            </div>
                            <p class="text-sm font-medium text-gray-900">${{ product.price }}</p>
                        </div>
                        <router-link :to="`/order/` + product.id"
                                     class="mt-2 group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Place to order
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import axios from "axios";
    import Config from '../config/index'
    export default {
        data() {
            return {
                BASE_PATH : Config.baseUrl,
                sortOptions: [
                    {text: 'Price low to high', value: "lowest_price"},
                    {text: 'Price high to low', value: "highest_price"}
                ],
                parameters: {
                    query: ''
                },
                products: []
            }
        },
        methods: {
            getProducts() {
                return axios.get(Config.apiBasePath + '/product/list')
                    .then(response => {
                        if (response.data.status) {
                            this.products = response.data.products;
                        }
                    })
            },
            getProductByFilter(event) {
                return axios.get(Config.apiBasePath + '/product/filter?order_by=' + event.target.value)
                    .then(response => {
                        if (response.data.status) {
                            this.products = response.data.products;
                        }
                    })
            },
            getProductBySearch(event) {
                if (event.target.value.length > 1) {
                    return axios.get(Config.apiBasePath + '/product/search?search_key=' + event.target.value)
                        .then(response => {
                            if (response.data.status) {
                                this.products = response.data.products;
                            }
                        })
                } else {
                    this.getProducts();
                }

            }
        },
        created() {
            this.getProducts();
        },
        mounted() {

        }
    }
</script>