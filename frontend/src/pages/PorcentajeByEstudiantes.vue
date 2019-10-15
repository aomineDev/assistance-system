<template>
  <v-container>
    <transition name="fade">
      <loader-ful-page v-if="isLoading" />
    </transition>

    <template v-if="!isLoading">
      <section class="Procentaje-header py-3">
        <v-btn
          icon
          large
          dark
          color="blue"
          :to="{name: 'cursos'}"
        >
          <v-icon>keyboard_arrow_left</v-icon>
        </v-btn>
        <h1 class="heading">{{ curso.curso }}</h1>
        <v-btn
          fab
          dark
          color="blue"
          @click="refresh"
        >
          <v-icon>refresh</v-icon>
        </v-btn>
      </section>

      <section class="Procentaje-body pa-5">
        <v-row>
            <v-col cols="1" class="font-weight-bold text-center">N°</v-col>
            <v-col cols="2" class="font-weight-bold">Código</v-col>
            <v-col cols="6" class="font-weight-bold">Apellidos y Nombres</v-col>
            <v-col cols="3" class="font-weight-bold text-center">Porcentaje</v-col>
          </v-row>

          <template v-if="students.length">
            <div v-for="(student, i) of students" :key="student.id">
              <v-row align="center">
                <v-col cols="1" class="text-center">{{ i | getIndex }}</v-col>
                <v-col cols="2">{{ student.codigo }}</v-col>
                <v-col cols="6">{{ student.nombre }}</v-col>
                <v-col cols="3" class="text-center">
                  <v-progress-circular
                    :rotate="-90"
                    :size="50"
                    :width="3"
                    :value="porcentajesValues[i].value"
                    :color="porcentajesValues[i].color"
                  >
                    <span class="Procentaje-progress-text">{{ porcentajesValues[i].value }}%</span>
                  </v-progress-circular>
                </v-col>
              </v-row>
              <v-divider></v-divider>
            </div>
          </template>
      </section>
    </template>

    <transition name="slideY">
      <alert />
    </transition>

  </v-container>
</template>

<script>
import { mapActions, mapMutations, mapState } from 'vuex'

import Alert from '@/components/shared/Alert'
import LoaderFulPage from '@/components/shared/LoaderFullPage'

export default {
  components: {
    Alert,
    LoaderFulPage
  },
  data () {
    return {
      isLoading: true,
      id: 0,
      curso: { curso: 'No existe el curso' },
      students: [],
      asistencias: [],
      porcentajesValues: [],
      porcentajeTotal: 0,
      porcentajeIndex: 0
    }
  },
  methods: {
    async init () {
      try {
        this.id = parseInt(this.$route.params.id)

        await this.verifyParams()

        const response = this.cursos.find(e => e.curso_id === this.id)
        this.docenteId = response.docente_id

        const config = {
          cursoId: this.id,
          docenteId: this.docenteId
        }

        if (this.porcentajes.length === 0) {
          await this.getPorcentajes(config)
        } else {
          if (this.porcentajes[0].curso_id !== this.id) {
            await this.getPorcentajes(config)
          }
        }
        this.assignPorcentaje()
      } catch (error) {
        this.handleTokenError()
      } finally {
        this.isLoading = false
      }
    },
    // Refresh asistencias
    async refresh () {
      try {
        this.isLoading = true
        const config = {
          cursoId: this.id,
          docenteId: this.docenteId
        }

        await this.getPorcentajes(config)

        this.assignPorcentaje()
      } catch (error) {
        this.handleTokenError()
      } finally {
        this.isLoading = false
      }
    },
    // Verify
    async verifyParams () {
      try {
        if (this.cursos.length === 0) {
          await this.getCursos()
        }

        const verify = this.cursos.some(item => item.curso_id === this.id)

        if (!verify) {
          this.$router.push({ name: 'notFound' })
        }
      } catch (error) {
        this.handleTokenError()
      }
    },
    // Assigns
    assignPorcentaje () {
      if (this.porcentajes.length !== 0) {
        this.curso = this.porcentajes[0]
        this.students = this.curso.estudiantes
        this.asistencias = []
        this.porcentajes.forEach((e, i) => {
          e.estudiantes.forEach((item, index) => {
            if (i === 0) {
              this.asistencias[index] = []
            }
            this.asistencias[index].push(item.firma)
          })
        })

        this.porcentajesValues = []
        this.asistencias.forEach(e => {
          this.porcentajeTotal = 0
          this.porcentajeIndex = 0
          e.forEach((item, index) => {
            this.porcentajeTotal++
            if (item) {
              this.porcentajeIndex++
            }
          })
          const porcentaje = Math.round((this.porcentajeIndex * 100) / this.porcentajeTotal)
          let porcentajeColor = null
          if (porcentaje <= 35) {
            porcentajeColor = 'red'
          }
          if (porcentaje > 35) {
            porcentajeColor = 'green'
          }
          if (porcentaje >= 70) {
            porcentajeColor = 'blue'
          }
          const obj = { value: porcentaje, color: porcentajeColor }
          this.porcentajesValues.push(obj)
        })
      }
    },
    // Handle Errror
    handleTokenError () {
      this.snackbarMutation({
        value: true,
        color: 'red',
        text: 'El Token ha expirado'
      })
      setTimeout(this.logoutAndGoToLogin, 3200)
    },
    async logoutAndGoToLogin () {
      await this.logout()
      this.$router.push({ name: 'login' })
    },
    ...mapMutations(['snackbarMutation']),
    ...mapActions(['getPorcentajes', 'getCursos', 'logout'])
  },
  computed: {
    ...mapState(['porcentajes', 'cursos', 'user'])
  },
  created () {
    this.init()
  }
}
</script>

<style lang="scss" scoped>
@import '@/scss/styles.scss';

.Procentaje {
  &-header {
    @extend %page-header;
  }
  &-body {
    @extend %card-aomine;
    margin-top: 48px;
    box-shadow: $shadow-small;
    @include desktop($bp-sm) {
      box-shadow: none;
    }
  }
  &-progress-text {
    font-size: 13px;
  }
}
</style>
