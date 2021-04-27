require("./bootstrap");

// window.Vue = require("vue").default;

// const app = new Vue({
//     el: '#app',
// });

// let app = createApp({});
// app.component("example", require("./components/ExampleComponent.vue").default);  // for tags
// app.mount("#main");

import axios from "axios";
import { createApp } from "vue";

import { createRouter, createWebHistory } from "vue-router";
import Admin from "./components/Shared/AdminComponent.vue";
import User from "./components/Shared/UserComponent.vue";

axios.defaults.withCredentials = true;
axios.defaults.baseURL = "http://localhost:8000";

// routes

const loadUserGroupComponents = (componenet) => {
    return import(
        /* webpack-ChunkName: 'userGroup' */ `./components/User/${componenet}.vue`
    );
};

const loadAdminGroupComponents = (componenet) => {
    return import(
        /* webpack-ChunkName: 'adminGroup' */ `./components/Admin/${componenet}.vue`
    );
};

const loadSharedGroupComponents = (componenet) => {
    return import(
        /* webpack-ChunkName: 'sharedGroup' */ `./components/Shared/${componenet}.vue`
    );
};

const UserRoutes = [
    {
        path: "/",
        name: "base",
        component: loadSharedGroupComponents("HomeComponent"),
    },
    {
        path: "/home",
        name: "home",
        component: loadSharedGroupComponents("HomeComponent"),
    },

    {
        path: "/create-order",
        name: "create-order",
        component: loadUserGroupComponents("CreateOrderComponent"),
    },
    {
        path: "/my-order",
        name: "my-order",
        component: loadUserGroupComponents("AllOrdersComponenet"),
    },

    { path: "/:catchAll(.*)", component: loadSharedGroupComponents("handler") },
];

const AdminRoutes = [
    { name: "base", path: "/", component: loadSharedGroupComponents("HomeComponent")},
    { name: "home", path: "/home", component: loadSharedGroupComponents("HomeComponent") },

    { name: "allProducts", path: "/products", component: loadAdminGroupComponents("AllProductsComponent")},
    { name: "addProduct", path: "/add_product", component: loadAdminGroupComponents("AddProductComponent")},
    { name: "updateProduct", path: "/update_product/:productId", component: loadAdminGroupComponents("UpdateProductComponent") },

    { name: 'alluser', path:'/alluser', component: loadAdminGroupComponents("allusercomponent")},
    { name: 'edit', path:'/edit/:id', component: loadAdminGroupComponents("editeUserComponent")},                  
    { name: 'store', path:'/userstore', component: loadAdminGroupComponents("addUserComponent")},

    { name: 'checks', path:"/checks", component: loadAdminGroupComponents("ChecksComponent")}, 
    { name: 'checkOrder', path:"/checkOrder/:id", component: loadAdminGroupComponents("CheckOrderComponent")}, 

    { name: "handler", path: "/:catchAll(.*)", component: loadSharedGroupComponents("handler") },
];

export let user;

window.addEventListener("load", function (e) {
    const userRouter = createRouter({
        history: createWebHistory(),
        routes: UserRoutes,
    });
    const adminRouter = createRouter({
        history: createWebHistory(),
        routes: AdminRoutes,
    });
    axios.get("/api/user").then((response) => {
        if (response.data.is_admin) {
            createApp(Admin).use(adminRouter).mount("#main");
            user = response.data;
        } else {
            createApp(User).use(userRouter).mount("#main");
            user = response.data;

        }
    });
});
