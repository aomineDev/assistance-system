<template>
  <v-app>
    <transition name="scale-page">
      <router-view />
    </transition>
  </v-app>
</template>

<script>
// eslint-disable-next-line
import { service } from '@/services/service'

import '@/scss/transitions.scss'

export default {
  name: 'App'
}
</script>
