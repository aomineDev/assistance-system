import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    drawerState: false,
    snackbarState: false,
    color: '',
    text: ''
  },
  mutations: {
    drawerMutation (state, value) {
      state.drawerState = value
    },
    snackbarMutation (state, { value, color, text }) {
      state.snackbarState = value
      state.color = color
      state.text = text
    }
  },
  actions: {

  }
})
