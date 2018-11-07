/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
Vue.use(VueRouter);

import { Form, HasError, AlertError } from "vform";
import VueRouter from "vue-router";

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

const router = new VueRouter({
    routes: [
        { path: "/home", component: require("./components/HomeComponent.vue") },
        { path: "/items", component: require("./components/ItemsComponent.vue") }
    ],
    mode: "history",
    linkExactActiveClass: 'active',
});

// Vue.component(
//     "example-component",
//     require("./components/ExampleComponent.vue")
// );

const app = new Vue({
    el: "#app",
    router
});
