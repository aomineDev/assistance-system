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
        <v-switch v-model="enabled" inset :disabled="disabledEnabled">
          <template v-slot:label>
            Habilitar Asistencia
            <v-progress-circular
            v-show="loadingEnabled"
              :indeterminate="loadingEnabled"
              :value="0"
              size="24"
              class="ml-2"
            ></v-progress-circular>
          </template>
        </v-switch>
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
            <v-col :cols="action" class="font-weight-bold text-center">Actions</v-col>
          </v-row>

          <div v-for="(student, i) of students" :key="student.id">
            <v-row align="center">
              <v-col cols="1" class="text-center">{{ i | number }}</v-col>
              <v-col cols="2">{{ student.codigo }}</v-col>
              <v-col :cols="nombre">{{ student.nombre }}</v-col>
              <v-col :cols="notas" class="" v-show="notas">
                <v-text-field
                  label="Nota"
                  single-line
                  v-mask="'##'"
                  counter
                  :rules="[rules.notas]"
                ></v-text-field>
              </v-col>
              <v-col :cols="nEquipo" class="text-center" v-show="nEquipo">{{ student.firma }}</v-col>
              <v-col :cols="firma" class="text-center">
                <v-icon color="blue" v-show="student.firma">flag</v-icon>
              </v-col>
              <v-col :cols="action" class="text-center">
                <v-btn icon :color="student.firma ? 'red': 'green'" @click="changeAsistencias(i)">
                  <v-icon>{{ student.firma ? 'clear' : 'done' }}</v-icon>
                </v-btn>
              </v-col>
            </v-row>
            <v-divider></v-divider>
          </div>
      </section>

      <v-dialog v-model="dialog" max-width="600px">
          <v-card>
            <v-card-title>
              <span class="headline">Details</span>
            </v-card-title>
            <v-card-text class="pb-0">
              <v-form
                @submit.prevent="saveDetails"
                autocomplete="off"
                ref="form"
                v-model="valid"
                lazy-validation
              >
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="6">
                      <v-text-field
                        label="Aula"
                        v-model="details.aula"
                        :disabled="disabled"
                        :rules="[rules.required, rules.aula]"
                        counter="3"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                      <v-text-field
                        label="Tema Desarrollado"
                        v-model="details.tema"
                        :disabled="disabled"
                        :rules="[rules.required, rules.tema]"
                        counter="50"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                      <v-text-field
                        label="Software Utilizado"
                        v-model="details.software"
                        :disabled="disabled"
                        :rules="[rules.required, rules.software]"
                        counter="20"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                      <v-text-field
                        label="% de avance"
                        v-model="details.avance"
                        suffix="%"
                        v-mask="'###'"
                        counter="3"
                        :disabled="disabled"
                        :rules="[rules.required, rules.avance]"
                      ></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="6">
                      <v-menu
                        v-model="menu"
                        :close-on-content-click="false"
                        transition="scale-transition"
                        offset-y
                        max-width="290px"
                        min-width="290px"
                      >
                        <template v-slot:activator="{ on }">
                          <v-text-field
                            v-model="details.fecha"
                            label="Fecha"
                            prepend-inner-icon="event"
                            readonly
                            v-on="on"
                            :disabled="disabled"
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="date"
                          @input="menu = false"
                          min="2019-01-01"
                          :max="maxDate"
                        ></v-date-picker>
                      </v-menu>
                    </v-col>
                    <v-col cols="12" sm="6">
                      <v-select
                        :items="proyectorItems"
                        item-text="text"
                        item-value="value"
                        label="¿Utilizo Proyector?"
                        v-model="details.proyector"
                        :disabled="disabled"
                      ></v-select>
                    </v-col>
                    <v-col class="d-none">
                      <v-btn type="submit"></v-btn>
                    </v-col>
                  </v-row>
                </v-container>
              </v-form>
            </v-card-text>
            <v-card-actions>
              <div class="flex-grow-1"></div>
              <v-btn color="red" text @click="dialog = false" :disabled="disabled">Close</v-btn>
              <v-btn
                color="green"
                text
                @click="saveDetails"
                :disabled="!valid"
                :loading="loadingBtn"
              >Save</v-btn>
            </v-card-actions>
          </v-card>
      </v-dialog>

      <v-dialog v-model="sure" max-width="290" persistent>
        <v-card>
          <v-card-title class="headline">Confirmación</v-card-title>

          <v-card-text>
            ¿Seguro de guardar los cambios?
          </v-card-text>

          <v-card-actions>
            <div class="flex-grow-1"></div>

            <v-btn
              color="red darken-1"
              text
              @click="cancelFirmas"
            >
              Cancelar
            </v-btn>

            <v-btn
              color="green darken-1"
              text
              @click="saveFirmas"
            >
              Aceptar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <transition-group name="scale-rotate">
        <v-speed-dial
          :key="'dial'"
          v-model="fab"
          fixed
          bottom
          right
          direction="top"
          open-on-hover
          transition="slide-y-reverse-transition"
          v-show="observer"
        >
          <template v-slot:activator>
            <v-btn
              v-model="fab"
              color="blue"
              dark
              fab
              large
              :loading="loadingFloatBtn"
            >
              <v-icon v-if="fab">close</v-icon>
              <v-icon v-else>work</v-icon>
            </v-btn>
          </template>
          <v-btn
            fab
            dark
            small
            color="indigo"
            @click="dialog = true"
          >
            <v-icon>edit</v-icon>
          </v-btn>
          <v-btn
            fab
            dark
            small
            color="red"
            @click="toogleNotas"
          >
            <v-icon>assignment</v-icon>
          </v-btn>
        </v-speed-dial>

        <v-btn
          :key="'button'"
          color="green"
          fixed
          fab
          large
          dark
          bottom
          right
          @click="sure = true"
          :loading="loadingFloatBtn"
          v-show="!observer"
        >
          <v-icon>check</v-icon>
        </v-btn>
      </transition-group>

      <transition name="move">
        <alert />
      </transition>

    </template>
  </v-container>
</template>

<script>
import { mapState, mapMutations } from 'vuex'
import { mask } from 'vue-the-mask'

import asistenciasService from '@/services/asistencias'

import Alert from '@/components/shared/Alert'
import LoaderFulPage from '@/components/shared/LoaderFullPage'

export default {
  components: {
    Alert,
    LoaderFulPage
  },
  directives: {
    mask
  },
  data () {
    return {
      students: [],
      studentsBup: [],
      trueStudents: [],
      header: {},
      details: {},
      proyectorItems: [
        { value: 1, text: 'Si' },
        { value: 0, text: 'No' }
      ],
      rules: {
        required: v => !!v || 'este campo es requerido.',
        curso: v => v.length <= 50 || '50 cáracteres como maximo',
        codigo: v => v.length <= 4 || '4 cáracteres como maximo',
        aula: v => v.length <= 3 || '3 cáracteres como maximo',
        docente: v => v.length <= 100 || '100 cáracteres como maximo',
        tema: v => v.length <= 50 || '50 cáracteres como maximo',
        software: v => v.length <= 20 || '50 cáracteres como maximo',
        avance: v => v <= 100 || '100% como máximo',
        notas: v => v <= 20 || 'invalid'
      },
      activeFab: {
        icon: 'edit',
        color: 'blue'
      },
      // PAGE
      isLoading: true,
      // STUDENTS TABLE
      nombre: 0,
      notas: 0,
      nEquipo: 0,
      firma: 0,
      action: 0,
      // MODALS
      dialog: false,
      sure: false,
      // FORMULARIO
      // interaccion
      disabled: false,
      loadingBtn: false,
      // validacion
      valid: true,
      // fechas
      date: new Date().toISOString().substr(0, 10),
      maxDate: new Date().toISOString().substr(0, 10),
      menu: false,
      // Buttons Float
      observer: true,
      loadingFloatBtn: false,
      fab: false,
      // Switch enabled/disabled
      enabled: false,
      loadingEnabled: false,
      disabledEnabled: false
    }
  },
  methods: {
    // Obtener Asistencias
    async getAsistencia () {
      try {
        const { data } = await asistenciasService.getAsitencia(this.asistenciaId)
        this.header = data.details
        this.students = data.students
        this.trueStudents = data.trueStudents
        this.date = this.header.fecha

        this.assignDetails()
        this.saveAsistenciasBup()

        // if (true) {
        this.assignCols(5, 0, 2, 1, 1)
        // } else {
        // this.assignCols(5, 0, 0, 2, 2)
        // }
      } catch (error) {
        this.snackbarMutation({
          value: true,
          color: 'red',
          text: 'Error al traer los datos'
        })
      } finally {
        this.isLoading = false
      }
    },
    // ENABLED ASITENCIA
    enabledAsistencia () {
      this.enabledToogle()
      // this.enabledToogle()
    },
    disabledAsistencia () {
      this.enabledToogle()
      this.enabledToogle()
    },
    enabledToogle () {
      this.disabledEnabled = !this.disabledEnabled
      this.loadingEnabled = !this.loadingEnabled
    },
    // FORMULARIO
    // Cambiar los disabled y loading del formulario
    toggleInputs () {
      this.disabled = !this.disabled
      this.loadingBtn = !this.loadingBtn
    },
    // Guardar los cambios de detail
    async saveDetails () {
      if (!this.$refs.form.validate()) {
        return
      }
      try {
        this.toggleInputs()
        this.details = {
          ...this.details,
          id: this.header.id,
          fecha: this.date
        }
        this.assignHeader()
        this.dialog = false
        this.loadingFloatBtn = true
        await asistenciasService.updateDetails(this.details)
        this.loadingFloatBtn = false
        this.snackbarMutation({
          value: true,
          color: 'green',
          text: 'Datos actualziados satisfactoriamente'
        })
      } catch (error) {
        this.snackbarMutation({
          value: true,
          color: 'red',
          text: 'Error al actulizar los datos en el servidor'
        })
      } finally {
        this.toggleInputs()
      }
    },
    // NOTAS
    toogleNotas () {
      if (this.notas) {
        this.assignCols(5, 0)
      } else {
        this.assignCols(4, 1)
      }
    },
    // ASISTENCIA
    // Guardar las asistencias Back Up
    saveAsistenciasBup () {
      this.studentsBup = []
      this.students.forEach(e => {
        this.studentsBup.push(e.firma)
      })
    },
    // Cambiar Asistencias
    changeAsistencias (i) {
      this.observer = false
      const idOne = this.students[i].id
      const index = this.trueStudents.findIndex(({ id }) => {
        return id === idOne
      })
      this.students[i].firma = this.students[i].firma ? 0 : 1
      this.trueStudents[index].firma = this.students[i].firma
    },
    // Cancelar el cambio de firmas
    cancelFirmas () {
      this.students.forEach((e, i, arr) => {
        arr[i].firma = this.studentsBup[i]
      })
      this.sure = false
      this.observer = true
    },
    // Guardar Firmas
    async saveFirmas () {
      try {
        this.saveAsistenciasBup()
        // Generate object de firmas
        let i = 0
        const firmas = this.trueStudents.reduce(function (obj, elem) {
          obj[i] = elem.firma
          i++
          return obj
        }, {})

        this.sure = false
        this.loadingFloatBtn = true

        await asistenciasService.updateAsistencias(firmas, this.header.id)

        this.snackbarMutation({
          value: true,
          color: 'green',
          text: 'Asistencias actualizadas correctamente'
        })
      } catch (error) {
        this.snackbarMutation({
          value: true,
          color: 'red',
          text: 'Error en el servidor'
        })
      } finally {
        this.loadingFloatBtn = false
        this.observer = true
      }
    },
    // ASSIGN
    assignHeader () {
      this.header.aula = this.details.aula
      this.header.tema = this.details.tema
      this.header.software = this.details.software
      this.header.avance = this.details.avance
      this.header.fecha = this.details.fecha
      this.header.proyector = this.details.proyector
    },
    assignDetails () {
      this.details.aula = this.header.aula
      this.details.tema = this.header.tema
      this.details.software = this.header.software
      this.details.avance = this.header.avance
      this.details.fecha = this.header.fecha.split('-').reverse().join('/')
      this.details.proyector = this.header.proyector
    },
    assignCols (nombre = this.nombre, notas = this.notas, nEquipo = this.nEquipo, firma = this.firma, action = this.action) {
      this.nombre = nombre
      this.notas = notas
      this.nEquipo = nEquipo
      this.firma = firma
      this.action = action
    },
    ...mapMutations(['snackbarMutation'])
  },
  computed: {
    proyector () {
      return this.header.proyector ? 'Si' : 'No'
    },
    ...mapState(['asistenciaId'])
  },
  watch: {
    date (value) {
      this.details.fecha = value.split('-').reverse().join('/')
    },
    dialog (value) {
      if (!value) {
        this.$refs.form.resetValidation()
      }
    },
    enabled (value) {
      if (value) {
        this.enabledAsistencia()
      } else {
        this.disabledAsistencia()
      }
    }
  },
  filters: {
    number (value) {
      return ++value
    }
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
