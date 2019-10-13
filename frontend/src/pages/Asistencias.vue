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
        <div></div>
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
  </v-container>
</template>

<script>
import { mapState, mapActions, mapMutations } from 'vuex'
import LoaderFulPage from '@/components/shared/LoaderFullPage'

export default {
  components: {
    LoaderFulPage
  },
  data () {
    return {
      enableAsistencias: [],
      disableAsistencias: [],
      id: null,
      isLoading: true,
      now: new Date().toISOString().substr(0, 10)
    }
  },
  methods: {
    async init () {
      try {
        this.id = parseInt(this.$route.params.id)

        await this.verifyParams()

        if (this.asistencias.length === 0) {
          await this.getAsistencias(this.id)
        } else {
          if (this.asistencias[0].curso_id !== this.id) {
            await this.getAsistencias(this.id)
          }
        }

        this.assignAsistencias()
      } catch (error) {
        console.log(error)
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
        console.log(error)
      }
    },
    // Assigns
    assignAsistencias () {
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
      this.$router.push({ name: 'asistencia' })
    },
    ...mapMutations(['asistenciaIdMutation']),
    ...mapActions(['getAsistencias', 'getCursos'])
  },
  computed: {
    ...mapState(['asistencias', 'cursos'])
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
