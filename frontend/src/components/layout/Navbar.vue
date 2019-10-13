<template>
  <div>
    <v-app-bar color="deep-purple" dark app>
      <v-app-bar-nav-icon @click.stop="drawerMutation(true)"></v-app-bar-nav-icon>
      <v-toolbar-title>Control de asistencia</v-toolbar-title>
      <div class="flex-grow-1"></div>

      <v-toolbar-items>
        <v-btn icon @click="notifications++">
          <v-badge
            overlap
            v-model="show"
          >
            <template v-slot:badge>{{ notifications }}</template>
            <v-icon>notifications</v-icon>
          </v-badge>
        </v-btn>

        <v-btn icon @click="decrement">
          <v-icon>person</v-icon>
        </v-btn>
      </v-toolbar-items>
    </v-app-bar>
  </div>
</template>

<script>
import { mapMutations } from 'vuex'

export default {
  data () {
    return {
      notifications: 0,
      show: false
    }
  },
  methods: {
    decrement () {
      if (this.notifications !== 0) {
        this.notifications--
      }
    },
    ...mapMutations(['drawerMutation'])
  },
  watch: {
    notifications (value) {
      if (value) {
        this.show = true
      }

      if (value === 0) {
        this.show = false
      }
    }
  }
}
</script>
