<template>
  <ul class="text-right p-4 font-semibold bg-indigo-600 pr-4">
      <li class="inline mx-2 text-white hover:text-pink-400 cursor-pointer">
          <router-link to="/" class="nav-link">
              Home
          </router-link>
      </li>
      <li v-if="!currentUser" class="inline mx-2 text-white hover:text-pink-400 cursor-pointer">
          <router-link to="/login" class="nav-link">
               Login
          </router-link>
      </li>
      <li v-if="!currentUser" class="inline mx-2 text-white hover:text-pink-400 cursor-pointer">
          <router-link to="/register" class="nav-link">
              Sign Up
          </router-link>
      </li>
     <li v-if="currentUser" class="inline mx-2 text-white hover:text-pink-400 cursor-pointer">
          <router-link to="/order-history" class="nav-link">
              Order History
          </router-link>
      </li>
        <li v-if="currentUser" class="inline mx-2 text-white hover:text-pink-400 cursor-pointer">
          <router-link to="/login" class="nav-link">
              {{ currentUser.user.username }}
          </router-link>
      </li>
     <li v-if="currentUser" class="inline mx-2 text-white hover:text-pink-400 cursor-pointer">
          <a @click.prevent="logOut" class="nav-link">
              Log Out
          </a> 
      </li>


  </ul>
</template>

<script>
export default {
  computed: {
    currentUser() {
      return this.$store.state.auth.user;
    }, 
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    },
  },
  methods: {
    logOut() {
      this.$store.dispatch('auth/logout');
      this.$router.push('/login');
    }
  }
};
</script>

<style>

</style>