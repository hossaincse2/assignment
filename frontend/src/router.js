import { createWebHistory, createRouter } from "vue-router";
import Home from "./page/Home.vue";
import Login from "./page/Login.vue";
import Register from "./page/Register.vue";
import Order from "./page/Order.vue";
import OrderHistory from "./page/OrderHistory.vue";
// lazy-loaded
// const Profile = () => import("./components/Profile.vue")
// const BoardAdmin = () => import("./components/BoardAdmin.vue")
// const BoardModerator = () => import("./components/BoardModerator.vue")
// const BoardUser = () => import("./components/BoardUser.vue")

const routes = [
    {
        path: "/",
        name: "home",
        component: Home,
    },
    {
        path: "/home",
        component: Home,
    },
    {
        path: "/login",
        component: Login,
    },
    {
        path: "/register",
        component: Register,
    },
    {
        path: "/order/:id",
        name: "order",
        props: true,
        component: Order,
    },
    {
        path: "/order-history",
        name: "order-history",
        // lazy-loaded
        component: OrderHistory,
    },
    // {
    //     path: "/admin",
    //     name: "admin",
    //     // lazy-loaded
    //     component: BoardAdmin,
    // },
    // {
    //     path: "/mod",
    //     name: "moderator",
    //     // lazy-loaded
    //     component: BoardModerator,
    // },
    // {
    //     path: "/user",
    //     name: "user",
    //     // lazy-loaded
    //     component: BoardUser,
    // },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
  });

router.beforeEach((to, from, next) => {
    const publicPages = ['/login', '/register', '/home','/','/order'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('user');

    // trying to access a restricted page + not logged in
    // redirect to login page
    if (authRequired && !loggedIn) {
        next('/login');
    } else {
        next();
    }
});
export default router;