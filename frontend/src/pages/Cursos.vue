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
          cols="12"
          sm="6"
          md="4"
        >
          <v-card>
            <v-card-title>{{ curso.nombre }}</v-card-title>
            <v-card-text>
              <p v-show="isStudent"><strong>{{ curso.docente }}</strong></p>
              <p>Ver lista de asistencias</p>
            </v-card-text>
            <v-card-actions>
              <v-btn
                text
                color="blue"
                :to="{name: 'asistencias', params: { id: curso.curso_id }}"
              >Aqui!</v-btn>
              <v-btn
                text
                color="deep-purple"
                v-show="isTeacher"
                :to="{name: 'porcentaje', params: { id: curso.curso_id }}"
              >Porcentajes</v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </template>

    <transition name="slideY">
      <alert />
    </transition>
  </v-container>
</template>

<script>
import { mapState, mapActions, mapMutations } from 'vuex'

import LoaderFulPage from '@/components/shared/LoaderFullPage'
import Alert from '@/components/shared/Alert'

export default {
  components: {
    Alert,
    LoaderFulPage
  },
  data () {
    return {
      isLoading: true,
      isStudent: false,
      isTeacher: false
    }
  },
  methods: {
    async init () {
      try {
        if (this.cursos.length === 0) {
          await this.getCursos()
        }
        if (this.user.rol === 'estudiante') {
          this.isStudent = true
        } else {
          this.isTeacher = true
        }
      } catch (error) {
        this.snackbarMutation({
          value: true,
          color: 'red',
          text: 'El Token ha expirado'
        })
        setTimeout(this.logoutAndGoToLogin, 3200)
      } finally {
        this.isLoading = false
      }
    },
    async logoutAndGoToLogin () {
      await this.logout()
      this.$router.push({ name: 'login' })
    },
    ...mapActions(['getCursos', 'logout']),
    ...mapMutations(['snackbarMutation'])
  },
  computed: {
    ...mapState(['cursos', 'user'])
  },
  created () {
    this.init()
  }
}
</script>
