<template>
<Product/>
</template>
<script>
  import { ref } from 'vue'
  const count = ref(0)
  import Product from '../components/Product.vue'
  export default {
    name: 'App',
    components: {
      Product
    },
    computed: {
      

    },
    methods: {
       
    }
  }

</script>
<style scoped>
a {
  color: #42b983;
}
</style>
