<template>
  <v-app>
    <navbar />
    <sidenav />

    <v-content>
      <router-view/>
    </v-content>
  </v-app>
</template>

<script>
import Navbar from './layout/Navbar'
import Sidenav from './layout/Sidenav'

export default {
  name: 'App',
  components: {
    Navbar,
    Sidenav
  },
  data () {
    return {

    }
  }
}
</script>
