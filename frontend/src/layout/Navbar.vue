<template>
  <div>
    <v-app-bar color="deep-purple" dark app>
      <v-app-bar-nav-icon @click.stop="drawerMutation(true)" class="d-sm-none"></v-app-bar-nav-icon>
      <div class="flex-grow-1 d-sm-none"></div>
      <v-toolbar-title class="d-none d-sm-flex">Control de asistencia</v-toolbar-title>
      <v-toolbar-title class="d-sm-none ml-n5">Control de asistencia</v-toolbar-title>
      <div class="flex-grow-1"></div>

      <v-toolbar-items class="d-none d-sm-flex">
        <v-btn icon>
          <v-icon>search</v-icon>
        </v-btn>

        <v-btn icon>
          <v-icon>notifications</v-icon>
        </v-btn>

        <v-btn icon>
          <v-icon>more_vert</v-icon>
        </v-btn>
      </v-toolbar-items>
    </v-app-bar>
  </div>
</template>

<script>
import { mapMutations } from "vuex";

export default {
  methods: {
    ...mapMutations(["drawerMutation"])
  }
};
</script>
