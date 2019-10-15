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
            <v-avatar color="deep-purple" size="48" class="mb-1">
                <v-icon dark>ac_unit</v-icon>
                <!-- <img
                  src="https://cdn.vuetifyjs.com/images/john.jpg"
                  alt="John"
                > -->
              </v-avatar>
            <div class="subheading">{{ user.nombre }}</div>
            <div class="body-1">{{ user.email }}</div>
          </v-col>
        </v-row>
      </v-img>

      <v-list
        shaped
      >
        <v-list-item-group
          v-model="group"
          active-class="deep-purple--text"
        >

          <v-list-item :to="{name: 'cursos'}">
            <v-list-item-icon>
            <v-icon>book</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>Cursos</v-list-item-title>
          </v-list-item-content>
          </v-list-item>

          <v-list-item  :to="{name: 'login'}">
            <v-list-item-icon>
            <v-icon>person</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>Perfil</v-list-item-title>
          </v-list-item-content>
          </v-list-item>

          <v-list-item @click="logoutAndGoToLogin">
            <v-list-item-icon>
            <v-icon>exit_to_app</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item-content>
          </v-list-item>

        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'

export default {
  data () {
    return {
      group: null
    }
  },
  methods: {
    async logoutAndGoToLogin () {
      this.overlayMutation(true)
      await this.logout(true)
      this.overlayMutation(false)
      this.$router.push({ name: 'login' })
    },
    ...mapActions(['logout']),
    ...mapMutations(['drawerMutation', 'overlayMutation'])
  },
  computed: {
    ...mapState(['drawerState', 'user']),
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
