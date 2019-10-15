import Vue from 'vue'
import Vuex from 'vuex'

import asistenciasService from '@/services/asistencias'
import cursosService from '@/services/cursos'
import authService from '@/services/auth'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    // drawer
    drawerState: false,
    // snackbar
    snackbarState: false,
    color: '',
    text: '',
    // api
    baseUrl: 'http://localhost:8000/api',
    response: '',
    user: { access_token: '' },
    // cursos
    cursos: [],
    // asistencias
    asistencias: [],
    allAsistencias: [],
    asistenciaId: 0,
    // porcentaje
    porcentajes: [],
    // Page
    overlay: false
  },
  mutations: {
    drawerMutation (state, value) {
      state.drawerState = value
    },
    snackbarMutation (state, { value, color, text }) {
      state.snackbarState = value
      state.color = color
      state.text = text
    },
    overlayMutation (state, value) {
      state.overlay = value
    },
    userMutation (state, object) {
      state.user = object
    },
    cursosMutation (state, obj) {
      state.cursos = obj
    },
    asistenciasMutation (state, obj) {
      state.asistencias = obj
    },
    allAsistenciasMutation (state, obj) {
      state.allAsistencias = obj
    },
    asistenciaIdMutation (state, value) {
      state.asistenciaId = value
    },
    porcentajesMutation (state, arr) {
      state.porcentajes = arr
    }
  },
  actions: {
    // Auth
    async setUser ({ commit }, { credentials, session }) {
      const { data } = await authService.login(credentials)
      if (session) {
        window.sessionStorage.setItem('credentials', JSON.stringify(data))
      }
      commit('userMutation', data)
    },
    async logout ({ commit }, value) {
      if (value) {
        await authService.logout()
      }
      window.sessionStorage.removeItem('credentials')
      commit('cursosMutation', [])
      commit('asistenciasMutation', [])
      commit('asistenciaIdMutation', 0)
      commit('userMutation', { access_token: '' })
    },
    // Cursos
    async getCursos ({ state, commit }) {
      let response
      if (state.user.rol === 'docente') {
        response = await cursosService.getCursosByDocente(state.user.docente_id)
      } else {
        response = await cursosService.getCursosByEstudiante(state.user.estudiante_id)
      }
      const { data } = response
      commit('cursosMutation', data)
    },
    async getAsistencias ({ state, commit }, { cursoId, docenteId }) {
      let { data } = await asistenciasService.getAsistencias(cursoId, docenteId)
      if (state.user.rol === 'estudiante') {
        commit('allAsistenciasMutation', data)
        data = data.filter(e => e.habilitado)
      }
      commit('asistenciasMutation', data)
    },
    async getPorcentajes ({ commit }, { cursoId, docenteId }) {
      const { data } = await asistenciasService.getPorcentajes(cursoId, docenteId)
      commit('porcentajesMutation', data)
    }
  },
  getters: {
    getBaseUrl (state) {
      return state.baseUrl
    },
    getUser (state) {
      return state.user
    },
    getAsistenciaId (state) {
      return state.asistenciaId
    }
  }
})
