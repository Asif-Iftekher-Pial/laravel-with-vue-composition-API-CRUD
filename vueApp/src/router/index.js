import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue')
    },
    {
      path: '/product-list',
      name: 'product-list',
      component: () => import('../views/ProductIndexView.vue')
    },
    {
      path: '/product-create',
      name: 'product-create',
      component: () => import('../components/crudComponent/Create.vue')
    },
    {
      path: '/product-edit/:id',
      name: 'product-edit',
      component: () => import('../components/crudComponent/Edit.vue')
    },
  ]
})

export default router
