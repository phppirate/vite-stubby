import { createRouter, createWebHistory } from 'vue-router'

export default createRouter({
    history: createWebHistory('/app'),
    routes: [
        {path: '/', component: () => import('../views/dashboard.vue'), name: 'dashboard'},
    ]
})
