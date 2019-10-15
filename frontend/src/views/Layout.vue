<template>
  <div>
    <navbar />
    <template v-if="$vuetify.breakpoint.xsOnly">
      <sidenav />
    </template>
    <v-content>
      <transition name="fade-page">
        <router-view />
      </transition>
    </v-content>
  </div>
</template>

<script>
import Navbar from '@/components/layout/Navbar'
import Sidenav from '@/components/layout/Sidenav'

export default {
  components: {
    Navbar,
    Sidenav
  }
}
</script>
