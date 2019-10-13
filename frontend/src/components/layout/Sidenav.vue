<template>
  <v-navigation-drawer
      v-model="drawer"
      absolute
      temporary
    >
      <v-img :aspect-ratio="16/9" src="https://cdn.vuetifyjs.com/images/parallax/material.jpg" class="Sidenav-bg">
      <div class="Sidenav-brightness"></div>
        <v-row align="end" class="white--text pa-2 fill-height">
          <v-col>
            <v-avatar color="blue" size="48" class="mb-1">
                <v-icon dark>person</v-icon>
                <!-- <img
                  src="https://cdn.vuetifyjs.com/images/john.jpg"
                  alt="John"
                > -->
              </v-avatar>
            <div class="subheading">Jonathan Lee</div>
            <div class="body-1">aomine@gmail.com</div>
          </v-col>
        </v-row>
      </v-img>

      <v-list
        shaped
      >
        <v-list-item-group
          v-model="group"
          active-class="deep-purple--text text--accent-4"
        >
          <v-list-item :to="{name: 'cursos'}">
            <v-list-item-icon>
            <v-icon>book</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>Cursos</v-list-item-title>
          </v-list-item-content>
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

<style lang="scss" scoped>
.Sidenav {
  &-brightness {
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .2);
    z-index: -1;
  }
}
</style>
