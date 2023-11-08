import { createRouter, createWebHistory } from "vue-router";
import Home from "../js/components/Home.vue";
import Profile from "../js/components/Profile.vue";
import Search from "../js/components/Search.vue";
import Weather from "../js/components/Weather.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            name: "home",
            component: Home,
        },
        {
            path: "/profile",
            name: "profile",
            component: Profile,
        },
        {
            path: "/search",
            name: "search",
            component: Search,
        },
        {
            path: "/weather",
            name: "weather",
            component: Weather,
        },
    ],
});

export default router;
