import Vue from 'vue'
import Router from 'vue-router'
import store from './store'

import Login from '@/views/Login.vue'
import Layout from '@/views/Layout.vue'
import Cursos from '@/pages/Cursos.vue'
import PorcentajeByEstudiantes from '@/pages/PorcentajeByEstudiantes.vue'
import Asistencias from '@/pages/Asistencias.vue'
import AsistenciaDocente from '@/pages/AsistenciaDocente.vue'
import AsistenciaEstudiante from '@/pages/AsistenciaEstudiante.vue'
import Admin from '@/views/admin/Layout.vue'
import NotFound from '@/views/NotFound.vue'

Vue.use(Router)

function requireAuth (to, from, next) {
  if (!store.getters.getUser.token_type) {
    const data = window.sessionStorage.getItem('credentials')
    if (data) {
      store.commit('userMutation', JSON.parse(data))
    } else {
      next({ name: 'login' })
      return
    }
  }

  if (store.getters.getUser.rol === 'admin') {
    next({ name: 'admin' })
    return
  }

  next()
}

function requireUnAuth (to, from, next) {
  if (!store.getters.getUser.token_type) {
    const data = window.sessionStorage.getItem('credentials')
    if (data) {
      store.commit('userMutation', JSON.parse(data))
    } else {
      next()
      return
    }
  }

  if (store.getters.getUser.rol === 'admin') {
    next({ name: 'admin' })
    return
  }

  next('/')
}

function requireAdminRole (to, from, next) {
  if (!store.getters.getUser.token_type) {
    const data = window.sessionStorage.getItem('credentials')
    if (data) {
      store.commit('userMutation', JSON.parse(data))
    } else {
      next({ name: 'login' })
      return
    }
  }

  if (store.getters.getUser.rol !== 'admin') {
    next('/')
    return
  }
  next()
}

function requireDocenteRole (to, from, next) {
  if (to.name !== 'porcentaje') {
    if (store.getters.getAsistenciaId === 0) {
      next('/')
      return
    }
  }

  if (store.getters.getUser.rol !== 'docente') {
    next({ name: 'notFound' })
    return
  }

  next()
}

function requireEstudianteRole (to, from, next) {
  if (store.getters.getAsistenciaId === 0) {
    next('/')
    return
  }

  if (store.getters.getUser.rol !== 'estudiante') {
    next({ name: 'notFound' })
    return
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
      beforeEnter: requireAuth,
      redirect: { name: 'cursos' },
      children: [
        {
          path: 'cursos',
          name: 'cursos',
          component: Cursos
        },
        {
          path: 'porcentaje/:id',
          name: 'porcentaje',
          beforeEnter: requireDocenteRole,
          component: PorcentajeByEstudiantes
        },
        {
          path: 'asistencias/:id',
          name: 'asistencias',
          component: Asistencias
        },
        {
          path: 'asistencia/docente',
          name: 'asistenciaDocente',
          beforeEnter: requireDocenteRole,
          component: AsistenciaDocente
        },
        {
          path: 'asistencia/estudiante',
          name: 'asistenciaEstudiante',
          beforeEnter: requireEstudianteRole,
          component: AsistenciaEstudiante
        }
      ]
    },
    {
      path: '/admin',
      name: 'admin',
      beforeEnter: requireAdminRole,
      component: Admin
    },
    {
      path: '/login',
      name: 'login',
      beforeEnter: requireUnAuth,
      component: Login
    },
    {
      path: '*',
      name: 'notFound',
      component: NotFound
    }
  ]
})
