<template>
  <div>
    <v-app-bar color="deep-purple" dark app>
      <v-app-bar-nav-icon
        class="d-flex d-sm-none"
        @click.stop="drawerMutation(true)"
      ></v-app-bar-nav-icon>
      <div class="flex-grow-1 d-flex d-sm-none"></div>
      <v-toolbar-title>Control de asistencias</v-toolbar-title>
      <img src="@/assets/login/fis.svg" alt="fis logo" class="Navbar-logo">
      <div class="flex-grow-1"></div>

      <v-toolbar-items  class="d-none d-sm-flex">
        <v-btn
          text
          :to="{name: 'cursos'}"
        >
          Cursos
        </v-btn>

        <v-menu
          bottom
          origin="center center"
          transition="scale-transition"
          offset-y
        >
            <template v-slot:activator="{ on }">
              <v-btn
                icon
                v-on="on"
              >
                <v-icon>person</v-icon>
              </v-btn>
            </template>

            <v-list>
              <v-list-item
              >
                <v-list-item-title>Pefil</v-list-item-title>
              </v-list-item>
              <v-list-item
                @click="logoutAndGoToLogin"
              >
                <v-list-item-title>Logout</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
      </v-toolbar-items>
    </v-app-bar>
    <v-overlay
      opacity="0"
      :value="overlay"
    />
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'

export default {
  methods: {
    async logoutAndGoToLogin () {
      this.overlayMutation(!this.overlay)
      await this.logout(true)
      this.overlayMutation(!this.overlay)
      this.$router.push({ name: 'login' })
    },
    ...mapActions(['logout']),
    ...mapMutations(['drawerMutation', 'overlayMutation'])
  },
  computed: {
    ...mapState(['overlay'])
  }
}
</script>

<style lang="scss" scoped>
.Navbar {
  &-logo {
    width: 32px;
    transform: translateX(8px)
  }
}
</style>
