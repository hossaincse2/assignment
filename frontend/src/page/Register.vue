<template>
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow" />
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Sign up to your account
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Or 
                   <router-link to="/login"  class="font-medium text-indigo-600 hover:text-indigo-500">
                        Login
                   </router-link>
                </p>
            </div>
            <form class="mt-8 space-y-6" action="#" method="POST" @submit.prevent="handleRegister">
                <input type="hidden" name="remember" value="true" />
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="name" class="sr-only">Name</label>
                        <input id="name" name="name" type="text" v-model="form.name"  required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Name" />
                    </div>
                    <div>
                        <label for="email-address" class="sr-only">Email address</label>
                        <input id="email-address" name="email" type="email" v-model="form.email"  autocomplete="email" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900   focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address" />
                    </div>
                    <div>
                        <label for="user_name" class="sr-only">User Name</label>
                        <input id="user_name" name="user_name" v-model="form.user_name"  type="text"  required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="User Name" />
                    </div>
                     <div>
                        <label for="phone" class="sr-only">Phone</label>
                        <input id="phone" name="phone" v-model="form.phone" type="text"  required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Phone" />
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" v-model="form.password" type="password" autocomplete="current-password" required="" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password" />
                    </div>
                </div>


                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
            </span>
                        Sign up
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
  
import { notify } from "notiwind"

export default {
  name: "Register", 
  data() { 
    return {
      successful: false,
      loading: false,
      message: "", 
      form : {
          name: '',
          email: '',
          user_name: '',
          phone: '',
          password: '',
      }
    };
  },
  computed: {
    loggedIn() {
      return this.$store.state.auth.status.loggedIn;
    },
  },
  mounted() {
    if (this.loggedIn) {
      this.$router.push("/order-history");
    }
  },
  methods: {
    handleRegister() {
      this.message = "";
      this.successful = false;
      this.loading = true;

      this.$store.dispatch("auth/register", this.form).then(
        (data) => {
            if(data.status){
                notify({
                group: "foo",
                title: "Success",
                text: "Your account was registered!"
                }, 2000) // 2s
                this.$router.push("/login");
            }else{
                 notify({
                    group: "error",
                    title: "Error",
                    text: "Your email is already used!"
                    }, 4000)
            }
          
        },
        (error) => {
            notify({
                group: "error",
                title: "Error",
                text: "Your email is already used!"
                }, 4000)
        }
      );
    },
  },
};
</script>

<style>
</style>