<template>
  <v-container>
    <transition name="fade">
      <loader-ful-page v-if="isLoading" />
    </transition>

    <template v-if="!isLoading">
      <section class="Asistencia-header my-3">
        <v-btn
          icon
          large
          dark
          color="blue"
          @click="$router.go(-1)"
        >
          <v-icon>keyboard_arrow_left</v-icon>
        </v-btn>
        <h1 class="display-1">Asistencia</h1>
        <div></div>
      </section>

      <section class="Asistencia-detail pa-5">
          <v-row>
            <v-col class="font-weight-bold" sm="3" lg="2">Curso</v-col>
            <v-col sm="3" lg="5" class="text-truncate">{{ header.curso }}</v-col>
            <v-col class="font-weight-bold" sm="3" lg="2">Código</v-col>
            <v-col sm="3" lg="3">{{ header.codigo }}</v-col>
          </v-row>
          <v-row>
            <v-col class="font-weight-bold" sm="3" lg="2">Docente</v-col>
            <v-col sm="3" lg="5" class="text-truncate">{{ header.docente }}</v-col>
            <v-col class="font-weight-bold" sm="3" lg="2">Aula</v-col>
            <v-col sm="3" lg="3">{{ header.aula }}</v-col>
          </v-row>
          <v-row>
            <v-col class="font-weight-bold" sm="3" lg="2">Semestre</v-col>
            <v-col sm="3" lg="5">{{ header.semestre }}</v-col>
            <v-col class="font-weight-bold" sm="3" lg="2">Fecha</v-col>
            <v-col sm="3" lg="3">{{ header.fecha | formatDate }}</v-col>
          </v-row>
          <v-row>
            <v-col class="font-weight-bold" sm="3" lg="2">Tema Desarrollado</v-col>
            <v-col sm="3" lg="5" class="text-truncate">{{ header.tema }}</v-col>
            <v-col class="font-weight-bold" sm="3" lg="2">% de Avance Silabíco</v-col>
            <v-col sm="3" lg="3">{{ header.avance }}%</v-col>
          </v-row>
          <v-row>
            <v-col class="font-weight-bold" sm="3" lg="2">Software Utilizado</v-col>
            <v-col sm="3" lg="5">{{ header.software }}</v-col>
            <v-col class="font-weight-bold" sm="3" lg="2">Utilizo Projector</v-col>
            <v-col sm="3" lg="3">{{ proyector }}</v-col>
          </v-row>
      </section>

      <section class="Asistencia-body pa-5">
          <v-row>
            <v-col cols="1" class="font-weight-bold text-center">N°</v-col>
            <v-col cols="2" class="font-weight-bold">Código</v-col>
            <v-col :cols="nombre" class="font-weight-bold">Apellidos y Nombres</v-col>
            <v-col :cols="notas" class="font-weight-bold" v-show="notas">Notas</v-col>
            <v-col :cols="nEquipo" class="font-weight-bold text-center" v-show="nEquipo">N° De Equipo</v-col>
            <v-col :cols="firma" class="font-weight-bold text-center">Firma</v-col>
          </v-row>

          <div v-for="(student, i) of students" :key="student.id">
            <v-row align="center">
              <v-col cols="1" class="text-center">{{ i | getIndex }}</v-col>
              <v-col cols="2">{{ student.codigo }}</v-col>
              <v-col :cols="nombre">{{ student.nombre }}</v-col>
              <v-col :cols="notas" v-show="notas">nota</v-col>
              <v-col :cols="nEquipo" class="text-center" v-show="nEquipo">{{ student.firma }}</v-col>
              <v-col :cols="firma" class="text-center">
                <v-btn
                  icon
                  color="green"
                  @click="changeAsistencias(i)"
                  v-show="!student.firma"
                  v-if="student.estudiante_id === user.estudiante_id"
                  :loading="loadingBtn"
                >
                  <v-icon>done</v-icon>
                </v-btn>
                <v-icon color="blue" v-show="student.firma">flag</v-icon>
              </v-col>
            </v-row>
            <v-divider></v-divider>
          </div>
      </section>

      <transition name="slideY">
        <alert />
      </transition>

    </template>
  </v-container>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'

import asistenciasService from '@/services/asistencias'

import Alert from '@/components/shared/Alert'
import LoaderFulPage from '@/components/shared/LoaderFullPage'

export default {
  components: {
    Alert,
    LoaderFulPage
  },
  data () {
    return {
      students: [],
      studentsBup: [],
      header: {},
      // PAGE
      isLoading: true,
      // STUDENTS TABLE
      nombre: 0,
      notas: 0,
      nEquipo: 0,
      firma: 0,
      // Asistencia
      loadingBtn: false
    }
  },
  methods: {
    // Obtener Asistencias
    async getAsistencia () {
      try {
        const { data } = await asistenciasService.getAsitencia(this.asistenciaId)
        this.header = data.details
        this.students = data.students

        if (this.header.laboratorio) {
          this.assignCols(5, 0, 2, 2)
        } else {
          this.assignCols(7, 0, 0, 2)
        }
      } catch (error) {
        this.handleTokenError()
      } finally {
        this.isLoading = false
      }
    },
    // ASISTENCIA
    // Cambiar Firma y Guardar Firma
    async changeAsistencias (i) {
      try {
        this.loadingBtn = true
        const id = this.students[i].id

        await asistenciasService.updateAsistencia(1, id)

        this.students[i].firma = 1
        this.snackbarMutation({
          value: true,
          color: 'green',
          text: 'Asistencia Firmada :D'
        })
      } catch (error) {
        this.handleTokenError()
      } finally {
        this.loadingBtn = false
      }
    },
    // ASSIGN
    assignCols (nombre = this.nombre, notas = this.notas, nEquipo = this.nEquipo, firma = this.firma) {
      this.nombre = nombre
      this.notas = notas
      this.nEquipo = nEquipo
      this.firma = firma
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
    ...mapActions(['logout']),
    ...mapMutations(['snackbarMutation'])
  },
  computed: {
    proyector () {
      return this.header.proyector ? 'Si' : 'No'
    },
    ...mapState(['asistenciaId', 'user'])
  },
  created () {
    this.getAsistencia()
  }
}
</script>

<style lang='scss' scoped>
@import '@/scss/styles.scss';

.Asistencia {
  &-header {
    @extend %page-header;
  }
  &-detail,
  &-body {
    @extend %card-aomine;
    box-shadow: $shadow-small;
    @include desktop($bp-sm) {
      box-shadow: none;
    }
  }
  &-body {
    margin-top: 48px;
  }
}
</style>
