import Vue from 'vue'
import Vuex from 'vuex'

import asistenciasService from '@/services/asistencias'
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
    user: null,
    // cursos
    cursos: [],
    asistencias: [],
    // asistencias
    asistenciaId: 0
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
    userMutation (state, object) {
      state.user = object
    },
    cursosMutation (state, obj) {
      state.cursos = obj
    },
    asistenciasMutation (state, obj) {
      state.asistencias = obj
    },
    asistenciaIdMutation (state, value) {
      state.asistenciaId = value
    }
  },
  actions: {
    async setUser ({ commit }, { credentials, session }) {
      const { data } = await authService.login(credentials)
      if (session) {
        window.sessionStorage.setItem('credentials', JSON.stringify(data))
      }
      commit('userMutation', data)
    },
    async getCursos ({ state, commit }) {
      const { data } = await asistenciasService.getCursos(state.user.id)
      commit('cursosMutation', data)
    },
    async getAsistencias ({ commit }, id) {
      const { data } = await asistenciasService.getAsistencias(id)
      commit('asistenciasMutation', data)
    }
  },
  getters: {
    getBaseUrl (state) {
      return state.baseUrl
    },
    getAsistenciaId (state) {
      return state.asistenciaId
    }
  }
})
