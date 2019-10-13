<template>
  <v-container>
    <transition name="fade">
      <loader-ful-page v-if="isLoading" />
    </transition>

  <template v-if="!isLoading">
    <h1>Cursos</h1>
    <v-row>
      <v-col
        v-for="curso in cursos"
        :key="curso.curso_id"
        cols="4"
      >
        <v-card>
          <v-card-title>{{ curso.nombre }}</v-card-title>
          <v-card-text>Ver lista de asistencias</v-card-text>
          <v-card-actions>
            <v-btn
              text
              color="blue"
              :to="{name: 'asistencias', params: { id: curso.curso_id }}"
            >Aqui!</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </template>
  </v-container>
</template>

<script>
import { mapState, mapActions } from 'vuex'

import LoaderFulPage from '@/components/shared/LoaderFullPage'

export default {
  components: {
    LoaderFulPage
  },
  data () {
    return {
      isLoading: true
    }
  },
  methods: {
    async init () {
      try {
        if (this.cursos.length === 0) {
          await this.getCursos()
        }
        this.isLoading = false
      } catch (error) {
        console.log(error)
      }
    },
    ...mapActions(['getCursos'])
  },
  computed: {
    ...mapState(['cursos'])
  },
  created () {
    this.init()
  }
}
</script>
