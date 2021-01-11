import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
    children: [
      {
        path: '/inicio',
        name: 'Inicio',
        component: () => import(/* webpackChunkName: "about" */ '../views/Inicio.vue')
      },
      {
        path: '/usuarios',
        name: 'Usuarios',
        component: () => import(/* webpackChunkName: "about" */ '../views/Usuarios.vue')
      },
      {
        path: '/tareas',
        name: 'Tareas',
        component: () => import(/* webpackChunkName: "about" */ '../views/Tareas.vue')
      }
    ]
  },
  {
    path: '/auth',
    name: 'Auth',
    component: () => import(/* webpackChunkName: "about" */ '../views/Auth.vue')
  },
  {
    path: '/signup',
    name: 'Signup',
    component: () => import(/* webpackChunkName: "about" */ '../views/Signup.vue')
  },

]

const router = new VueRouter({
  routes
})

export default router
