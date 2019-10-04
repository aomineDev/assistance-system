<template>
  <v-navigation-drawer
      v-model="drawer"
      absolute
      temporary
    >
      <v-list
        nav
        dense
      >
        <v-list-item-group
          v-model="group"
          active-class="deep-purple--text text--accent-4"
        >
          <v-list-item>
            <v-list-item-title>Foo</v-list-item-title>
          </v-list-item>

          <v-list-item>
            <v-list-item-title>Bar</v-list-item-title>
          </v-list-item>

          <v-list-item>
            <v-list-item-title>Fizz</v-list-item-title>
          </v-list-item>

          <v-list-item>
            <v-list-item-title>Buzz</v-list-item-title>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
</template>

<script>
import { mapState, mapMutations } from 'vuex'

export default {
  data () {
    return {
      group: null
    }
  },
  methods: {
    ...mapMutations(['drawerMutation'])
  },
  computed: {
    ...mapState(['drawerState']),
    drawer: {
      get () {
        return this.drawerState
      },
      set (value) {
        this.drawerMutation(value)
      }
    }
  },
  watch: {
    group () {
      this.drawer = false
    }
  }
}
</script>
