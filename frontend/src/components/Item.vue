<template>
    <div class="grid grid-cols-10 overflow-hidden col-gap-6 mb-5">
        <img class="block col-span-4 w-full h-40 rounded bg-gray-600" :src="BASE_PATH +'/base-url-img/'+ item.image + '/thumbnail'" :alt="item.product_name" />
        <div class="ml-3 col-span-6">
            <div class="flex">
                <h6 class="text-sm font-semibold text-gray-800 flex-grow">{{ item.product_name }}</h6>
                <button>
                    <svg class="w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path
                                d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z"
                        />
                    </svg>
                </button>
            </div>
            <span class="text-sm text-gray-800">1 X {{ item.price }} USD</span>
            <div class="mt-4">
                <p>Total Amount: ${{item.price}}</p>
                <p>Total VAT: ${{item.vat_amt}}</p>
                <p>Net Total: ${{item.price + item.vat_amt}}</p>
            </div>
        </div>

    </div>
</template>

<script>
    import Config from '../config/index';

    export default {
        name: "Item",
        props: {
            item: Object
        },
        data() {
            return {
                BASE_PATH: Config.baseUrl,
            }
        }
    };
</script>