<template>
  <v-snackbar
      v-model="snackbar"
      :color="color"
      right
      :timeout="3000"
      top
    >
      <v-icon color="white" class="mr-3">add_alert</v-icon>
      {{ text }}
      <v-btn
        icon
        text
        @click="snackbarMutation({ value: false, color, text })"
      >
        <v-icon>clear</v-icon>
      </v-btn>
    </v-snackbar>
</template>

<script>
import { mapState, mapMutations } from 'vuex'

export default {
  methods: {
    ...mapMutations(['snackbarMutation'])
  },
  computed: {
    ...mapState(['snackbarState', 'color', 'text']),
    snackbar: {
      get () {
        return this.snackbarState
      },
      set (value) {
        this.snackbarMutation({ value, color: this.color, text: this.text })
      }
    }
  }
}
</script>
