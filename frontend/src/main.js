import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import {createRouter, createWebHistory} from 'vue-router';
import PostList from "@/components/Post/List.vue";
import PostForm from "@/components/Post/Form.vue";
import Login from "@/components/User/Login.vue";

const routes = [
    { path: '/', name: 'posts-list', component: PostList },
    { path: '/posts/create', name: 'posts-form', component: PostForm },
    { path: '/login', name: 'login', component: Login },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes, // short for `routes: routes`
})


createApp(App)
    .use(router)
    .mount('#app')
