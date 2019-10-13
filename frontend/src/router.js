import Vue from 'vue'
import Router from 'vue-router'
import store from './store'

import Login from '@/views/Login.vue'
import Layout from '@/views/Layout.vue'
import Cursos from '@/pages/Cursos.vue'
import Asistencia from '@/pages/Asistencia.vue'
import Asistencias from '@/pages/Asistencias.vue'
import NotFound from '@/views/NotFound.vue'

Vue.use(Router)

// function requireAuth (to, from, next) {
//   if (true) {
//     next({ name: 'cursos' })
//   }
// }

function requireAsistenciaId (to, from, next) {
  if (store.getters.getAsistenciaId === 0) {
    console.log(store.getters.getAsistenciaId)
    next('/login')
  }
  next()
}

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      component: Layout,
      redirect: { name: 'cursos' },
      children: [
        {
          path: 'cursos',
          name: 'cursos',
          component: Cursos
        },
        {
          path: 'asistencias/:id',
          name: 'asistencias',
          component: Asistencias
        },
        {
          path: 'asistencia',
          name: 'asistencia',
          beforeEnter: requireAsistenciaId,
          component: Asistencia
        }
      ]
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '*',
      name: 'notFound',
      component: NotFound
    }
  ]
})
