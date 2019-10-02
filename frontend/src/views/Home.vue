<template>
  <v-container>
    <section class="Home-header mt-5 pa-5">
      <v-row class="test-1">
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
        <v-col sm="3" lg="3">{{ header.fecha }}</v-col>
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

    <section class="Home-body pa-5">
      <v-row>
        <v-col cols="1" class="font-weight-bold text-center">N°</v-col>
        <v-col cols="2" class="font-weight-bold">Código</v-col>
        <v-col cols="5" class="font-weight-bold">Apellidos y Nombres</v-col>
        <v-col cols="2" class="font-weight-bold text-center">N° De Equipo</v-col>
        <v-col cols="1" class="font-weight-bold text-center">Firma</v-col>
        <v-col cols="1" class="font-weight-bold text-center">Actions</v-col>
      </v-row>

      <div v-for="(student, i) of students" :key="student.number">
        <v-row align="center">
          <v-col cols="1" class="text-center">{{ student.number }}</v-col>
          <v-col cols="2">{{ student.code }}</v-col>
          <v-col cols="5">{{ student.fullname }}</v-col>
          <v-col cols="2" class="text-center">{{ student.teamNumber }}</v-col>
          <v-col cols="1" class="text-center">
            <v-icon color="blue" v-show="student.signature">flag</v-icon>
          </v-col>
          <v-col cols="1" class="text-center">
            <v-btn icon :color="student.signature ? 'red': 'green'" @click="changeStatus(i)">
              <v-icon>{{ student.signature ? 'clear' : 'done' }}</v-icon>
            </v-btn>
          </v-col>
        </v-row>
        <v-divider></v-divider>
      </div>
    </section>

    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">Details</span>
        </v-card-title>
        <v-card-text class="pb-0">
          <v-form
            @submit.prevent="saveChanges"
            autocomplete="off"
            ref="form"
            v-model="valid"
            lazy-validation
          >
            <v-container>
              <v-row>
                <v-col cols="12" sm="6" md="4">
                  <v-text-field
                    label="Curso"
                    v-model="details.curso"
                    :disabled="disabled"
                    :rules="[rules.required, rules.curso]"
                    counter="50"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                  <v-text-field
                    label="Código"
                    v-model="details.codigo"
                    :disabled="disabled"
                    :rules="[rules.required, rules.codigo]"
                    counter="4"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="4">
                  <v-text-field
                    label="Aula"
                    v-model="details.aula"
                    :disabled="disabled"
                    :rules="[rules.required, rules.aula]"
                    counter="3"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="8">
                  <v-text-field
                    label="Docente"
                    v-model="details.docente"
                    :disabled="disabled"
                    :rules="[rules.required, rules.docente]"
                    counter="100"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-select
                    label="Semestre"
                    :items="semestres"
                    item-text="text"
                    item-value="value"
                    return-object
                    v-model="details.semestre"
                    :disabled="disabled"
                  ></v-select>
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
                <v-col cols="12" sm="6" md="4">
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
                <v-col cols="12" sm="6" md="4">
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
                <v-col cols="12" sm="6" md="4">
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
            @click="saveChanges"
            :disabled="!valid"
            :loading="loadingBtn"
          >Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-btn fixed dark fab bottom right color="blue" @click="dialog = true">
      <v-icon>edit</v-icon>
    </v-btn>

    <alert />
  </v-container>
</template>

<script>
import { mapMutations } from "vuex";
import { mask } from "vue-the-mask";

import Alert from "@/components/Alert";

export default {
  components: {
    Alert
  },
  directives: {
    mask
  },
  data() {
    return {
      students: [
        {
          number: 1,
          code: "2017100560K",
          fullname: "Carrión Alcocer Ariel Omar",
          teamNumber: 1,
          signature: false
        },
        {
          number: 2,
          code: "2017100560K",
          fullname: "Carrión Alcocer Ariel Omar",
          teamNumber: 1,
          signature: false
        },
        {
          number: 3,
          code: "2017100560K",
          fullname: "Carrión Alcocer Ariel Omar",
          teamNumber: 1,
          signature: false
        },
        {
          number: 4,
          code: "2017100560K",
          fullname: "Carrión Alcocer Ariel Omar",
          teamNumber: 1,
          signature: false
        },
        {
          number: 5,
          code: "2017100560K",
          fullname: "Carrión Alcocer Ariel Omar",
          teamNumber: 1,
          signature: false
        },
        {
          number: 6,
          code: "2017100560K",
          fullname: "Carrión Alcocer Ariel Omar",
          teamNumber: 1,
          signature: false
        },
        {
          number: 7,
          code: "2017100560K",
          fullname: "Carrión Alcocer Ariel Omar",
          teamNumber: 1,
          signature: false
        },
        {
          number: 8,
          code: "2017100560K",
          fullname: "Carrión Alcocer Ariel Omar",
          teamNumber: 1,
          signature: false
        },
        {
          number: 9,
          code: "2017100560K",
          fullname: "Carrión Alcocer Ariel Omar",
          teamNumber: 1,
          signature: false
        }
      ],
      header: {
        curso: "Técnologias Emergentes",
        codigo: "A46",
        aula: "201",
        docente: "Ing. Max Arana Caparachin Maglioli",
        semestre: "Tercero",
        tema: "Funciones y Bucles",
        software: "php",
        avance: "80",
        fecha: "26/09/2019",
        proyector: true
      },
      details: {
        curso: '',
        codigo: '',
        aula: '',
        docente: '',
        semestre: '',
        tema: '',
        software: '',
        avance: '',
        fecha: '',
        proyector: ''
      },
      proyectorItems: [
        { value: true, text: "Si" },
        { value: false, text: "No" }
      ],
      semestres: [
        { value: 1, text: "Primero" },
        { value: 2, text: "Segundo" },
        { value: 3, text: "Tercero" },
        { value: 4, text: "Cuarto" },
        { value: 5, text: "Quinto" },
        { value: 6, text: "Sexto" },
        { value: 7, text: "Septimo" },
        { value: 8, text: "Octavo" },
        { value: 9, text: "Noveno" },
        { value: 10, text: "Decimo" }
      ],
      rules: {
        required: v => !!v || "este campo es requerido.",
        curso: v => v.length <= 50 || "50 cáracteres como maximo",
        codigo: v => v.length <= 4 || "4 cáracteres como maximo",
        aula: v => v.length <= 3 || "3 cáracteres como maximo",
        docente: v => v.length <= 100 || "100 cáracteres como maximo",
        tema: v => v.length <= 50 || "50 cáracteres como maximo",
        software: v => v.length <= 20 || "50 cáracteres como maximo",
        avance: v => v <= 100 || "100% como máximo"
      },
      dialog: false,
      disabled: false,
      loadingBtn: false,
      valid: true,
      date: new Date().toISOString().substr(0, 10),
      maxDate: new Date().toISOString().substr(0, 10),
      menu: false
    };
  },
  methods: {
    changeStatus(i) {
      this.students[i].signature = !this.students[i].signature
    },
    toogleInputs() {
      this.disabled = !this.disabled
      this.loadingBtn = !this.loadingBtn
    },
    saveChanges() {
      if (!this.$refs.form.validate()) {
        return
      }
      this.toogleInputs();
      this.header.curso = this.details.curso
      this.header.codigo = this.details.codigo
      this.header.aula = this.details.aula
      this.header.docente = this.details.docente
      this.header.semestre = this.details.semestre.text
      this.header.tema = this.details.tema
      this.header.software = this.details.software
      this.header.avance = this.details.avance
      this.header.fecha = this.details.fecha
      this.header.proyector = this.details.proyector
      this.toogleInputs()
      this.dialog = false
      this.snackbarMutation({
        value: true,
        color: "green",
        text: "Datos actualziados satisfactoriamente"
      })
    },
    ...mapMutations(["snackbarMutation"])
  },
  computed: {
    proyector() {
      return this.header.proyector ? "Si" : "No";
    }
  },
  watch: {
    date(value) {
      this.details.fecha = value
        .split("-")
        .reverse()
        .join("/");
    }
  },
  beforeMount() {
    this.details.curso = this.header.curso;
    this.details.codigo = this.header.codigo;
    this.details.aula = this.header.aula;
    this.details.docente = this.header.docente;
    this.details.semestre = this.header.semestre;
    this.details.tema = this.header.tema;
    this.details.software = this.header.software;
    this.details.avance = this.header.avance;
    this.details.fecha = this.header.fecha;
    this.details.proyector = this.header.proyector;
  }
};
</script>

<style lang="scss" scoped>
@import "@/scss/styles.scss";

.Home {
  &-header,
  &-body {
    border-radius: 20px;
    @include mobile($bp-sm) {
      box-shadow: $shadow-1;
    }
  }
  &-body {
    margin-top: 40px;
  }
}
</style>
