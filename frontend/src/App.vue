<template>
  <Navbar/>
  <router-view />
  <Footer />
  <Notification/>
</template>

<script>
  import Navbar from './components/Navbar.vue'
  import Footer from './components/Footer.vue'
  import Notification from './components/Notification.vue'
  export default {
    name: 'App',
    components: {
      Navbar,
      Footer,
      Notification
    },
    computed: {
      // currentUser() {
      //   return this.$store.state.auth.user;
      // }, 
    },
    methods: {
      logOut() {
        this.$store.dispatch('auth/logout');
        this.$router.push('/login');
      }
    }
  }

</script>

<style>
</style>