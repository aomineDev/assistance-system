import Vue from 'vue'
import Vuex from 'vuex'

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
    user: {
      nombre_completo: 'aomine Daiki'
    }
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
    }
  },
  actions: {

  },
  getters: {
    getBaseUrl (state) {
      return state.baseUrl
    }
  }
})
