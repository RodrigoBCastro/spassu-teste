import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  { path: '/', name: 'home', component: () => import('@/views/HomeView.vue') },
  { path: '/autores', name: 'autores', component: () => import('@/views/AutoresView.vue') },
  { path: '/assuntos', name: 'assuntos', component: () => import('@/views/AssuntosView.vue') },
  { path: '/livros', name: 'livros', component: () => import('@/views/LivrosView.vue') },
]

export default createRouter({
  history: createWebHistory(),
  routes,
})
