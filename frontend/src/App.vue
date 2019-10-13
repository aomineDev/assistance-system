<template>
  <v-app>
    <transition name="fade">
      <LoaderInitial v-if="isLoading" />
    </transition>
    <template v-if="!isLoading">
      <transition name="fade">
        <router-view />
      </transition>
    </template>
  </v-app>
</template>

<script>
import { mapMutations } from 'vuex'

// eslint-disable-next-line
import service from '@/services/service'

import LoaderInitial from '@/components/shared/LoaderInitial'

import '@/scss/transitions.scss'

export default {
  name: 'App',
  components: {
    LoaderInitial
  },
  data () {
    return {
      isLoading: true
    }
  },
  methods: {
    async getUser () {
      const data = window.sessionStorage.getItem('credentials')
      this.isLoading = false
      if (data) {
        this.userMutation(data)
        console.log('alv puta mare k fueeee :\'V')
        // this.$router.push('/')
      } else {
        console.log('goto')
        // this.$router.push({ name: 'login' })
      }
    },
    ...mapMutations(['userMutation'])
  },
  created () {
    this.getUser()
  }
}
</script>
