import { createRouter, createWebHistory } from "vue-router";
import Home from "../js/components/Home.vue";
import Profile from "../js/components/Profile.vue";
import Search from "../js/components/Search.vue";
import Weather from "../js/components/Weather.vue";
import Others from "../js/components/Others.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: "/v/home",
            name: "home",
            component: Home,
        },
        {
            path: "/v/profile",
            name: "profile",
            component: Profile,
        },
        {
            path: "/v/search",
            name: "search",
            component: Search,
        },
        {
            path: "/v/weather",
            name: "weather",
            component: Weather,
        },
        {
            path: "/v/others/:userId",
            name: "others",
            component: Others,
            props:true,
        },
    ],
});

export default router;
