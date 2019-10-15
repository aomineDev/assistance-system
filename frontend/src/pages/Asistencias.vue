<template>
  <v-container>
    <transition name="fade">
      <loader-ful-page v-if="isLoading" />
    </transition>

    <template v-if="!isLoading">
      <section class="Asistencias-header py-3">
        <v-btn
          icon
          large
          dark
          color="blue"
          :to="{name: 'cursos'}"
        >
          <v-icon>keyboard_arrow_left</v-icon>
        </v-btn>
        <h1>Lista de Asistencias</h1>
        <div v-show="isStudent">
          Porcentaje de Asistencia
          <v-progress-circular
            :rotate="-90"
            :size="55"
            :width="3"
            :value="porcentaje"
            :color="porcentajeColor"
            class="ml-2"
          >
            {{ porcentaje }}%
          </v-progress-circular>
        </div>
        <div v-show="!isStudent"></div>
      </section>

      <v-list two-line subheader color="background">
        <template v-if="enableAsistencias.length">
          <v-subheader inset>Asistencias disponibles</v-subheader>
          <v-list-item
            v-for="asistencia in enableAsistencias"
            :key="asistencia.id"
            @click="goToAsistencia(asistencia.id)"
          >
            <v-list-item-avatar>
              <v-icon class="blue white--text">assignment</v-icon>
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title>{{ asistencia.curso }}</v-list-item-title>
              <v-list-item-subtitle>{{ asistencia.fecha | formatDate }}</v-list-item-subtitle>
            </v-list-item-content>

            <v-list-item-action>
              <v-btn icon>
                <v-icon color="grey lighten-1">navigate_next</v-icon>
              </v-btn>
            </v-list-item-action>
          </v-list-item>
        </template>

        <v-divider inset></v-divider>

        <template v-if="disableAsistencias.length">
          <v-subheader inset>Asistencias no disponibles</v-subheader>

          <v-list-item
            v-for="asistencia in disableAsistencias"
            :key="asistencia.id"
          >
            <v-list-item-avatar>
              <v-icon class="grey lighten-1 white--text">assignment</v-icon>
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title>{{ asistencia.curso }}</v-list-item-title>
              <v-list-item-subtitle>{{ asistencia.fecha | formatDate }}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-list>
    </template>

    <v-btn
      fixed
      bottom
      right
      fab
      dark
      color="blue"
      @click="refresh"
      :loading="loadingFloatBtn"
    >
      <v-icon>refresh</v-icon>
    </v-btn>

    <transition name="slideY">
      <alert />
    </transition>
  </v-container>
</template>

<script>
import { mapState, mapActions, mapMutations } from 'vuex'

import Alert from '@/components/shared/Alert'
import LoaderFulPage from '@/components/shared/LoaderFullPage'

export default {
  components: {
    Alert,
    LoaderFulPage
  },
  data () {
    return {
      enableAsistencias: [],
      disableAsistencias: [],
      id: null,
      docenteId: 0,
      isLoading: true,
      loadingFloatBtn: false,
      now: new Date().toISOString().substr(0, 10),
      porcentaje: 0,
      porcentajeTotal: 0,
      porcentajeIndex: 0,
      porcentajeColor: '',
      isStudent: false
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

        if (this.asistencias.length === 0) {
          await this.getAsistencias(config)
        } else {
          if (this.asistencias[0].curso_id !== this.id) {
            await this.getAsistencias(config)
          }
        }
        this.assignPorcentaje()
        this.assignAsistencias()
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
        this.loadingFloatBtn = true
        const config = {
          cursoId: this.id,
          docenteId: this.docenteId
        }

        await this.getAsistencias(config)

        this.assignPorcentaje()
        this.assignAsistencias()
      } catch (error) {
        this.handleTokenError()
      } finally {
        this.isLoading = false
        this.loadingFloatBtn = false
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
      if (this.user.rol === 'estudiante') {
        this.porcentajeTotal = 0
        this.porcentajeIndex = 0
        this.allAsistencias.forEach(({ estudiante }) => {
          this.porcentajeTotal++
          if (estudiante.firma) {
            this.porcentajeIndex++
          }
        })

        this.porcentaje = Math.round((this.porcentajeIndex * 100) / this.porcentajeTotal)

        if (this.porcentaje <= 35) {
          this.porcentajeColor = 'red'
        }
        if (this.porcentaje > 35) {
          this.porcentajeColor = 'green'
        }
        if (this.porcentaje >= 70) {
          this.porcentajeColor = 'blue'
        }
        this.isStudent = true
      }
    },
    assignAsistencias () {
      if (!this.asistencias.length) {
        this.enableAsistencias = []
        this.disableAsistencias = []
        return
      }

      const nowArr = this.now.split('-')
      const yearNow = parseInt(nowArr[0])
      const monthNow = parseInt(nowArr[1])
      const dayNow = parseInt(nowArr[2])
      this.enabledAsistencias(yearNow, monthNow, dayNow)
    },
    // Enabled toogle
    enabledAsistencias (yearNow, monthNow, dayNow) {
      this.enableAsistencias = this.asistencias.filter(item => {
        const date = item.fecha.split('-')
        const year = parseInt(date[0])
        const month = parseInt(date[1])
        const day = parseInt(date[2])
        if (year > yearNow) {
          this.disabledAsistencias(item)
          return false
        }
        if (year === yearNow) {
          if (month > monthNow) {
            this.disabledAsistencias(item)
            return false
          }
          if (month === monthNow) {
            if (day > dayNow) {
              this.disabledAsistencias(item)
              return false
            }
          }
        }
        return true
      })
    },
    disabledAsistencias (item) {
      this.disableAsistencias.push(item)
    },
    goToAsistencia (id) {
      this.asistenciaIdMutation(id)
      if (this.user.rol === 'docente') {
        this.$router.push({ name: 'asistenciaDocente' })
        return
      }

      if (this.user.rol === 'estudiante') {
        this.$router.push({ name: 'asistenciaEstudiante' })
      }
    },
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
    ...mapMutations(['asistenciaIdMutation', 'snackbarMutation']),
    ...mapActions(['getAsistencias', 'getCursos', 'logout'])
  },
  computed: {
    ...mapState(['allAsistencias', 'asistencias', 'cursos', 'user'])
  },
  created () {
    this.init()
  }
}
</script>

<style lang="scss" scoped>
@import '@/scss/styles.scss';

.Asistencias {
  &-header {
    @extend %page-header;
  }
}
</style>
