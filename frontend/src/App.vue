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
import { mapMutations } from 'vuex'
import authService from '@/services/auth'
import '@/scss/transitions.scss'

import Navbar from '@/components/layout/Navbar'
import Sidenav from '@/components/layout/Sidenav'

export default {
  name: 'App',
  components: {
    Navbar,
    Sidenav
  },
  methods: {
    async login (id) {
      const { data } = await authService.login(id)
      this.userMutation(data)
      console.log(data)
    },
    ...mapMutations(['userMutation'])
  },
  created () {
    this.login(1)
  }
}
</script>
