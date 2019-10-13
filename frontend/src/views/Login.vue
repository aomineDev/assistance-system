<template>
  <v-container class="d-flex justify-center align-center fill-height">
    <section class="Login">
        <v-card class="Login-card py-3" elevation="0">
          <v-card-title>
            <div class="flex-grow-1"></div>
            <h1 class="Login-title">
              Login
              <v-icon
                class="Login-title-icon"
              >person</v-icon>
            </h1>
            <div class="flex-grow-1"></div>
          </v-card-title>
          <v-card-text class="pb-0">
            <v-form
              @submit.prevent="login"
              autocomplete="off"
              ref="form"
              v-model="valid"
              lazy-validation
            >
              <v-text-field
                label="email"
                v-model="email"
                :disabled="disabled"
                :rules="[rules.required, rules.email]"
                :error-messages="errorMsg"
              ></v-text-field>
              <v-text-field
                label="password"
                :append-icon="show ? 'visibility' : 'visibility_off'"
                :type="show ? 'text' : 'password'"
                v-model="password"
                :disabled="disabled"
                :rules="[rules.required, rules.password]"
                :error-messages="errorMsg"
                @click:append="show = !show"
              ></v-text-field>
              <v-checkbox
                v-model="session"
                label="Recuerdame"
              />
              <v-btn
                type="submit"
                class="d-none"
              ></v-btn>
            </v-form>
          </v-card-text>
          <v-card-actions class="pt-0">
            <div class="flex-grow-1"></div>
            <v-btn
              color="blue white--text"
              :disabled="!valid"
              :loading="loadingBtn"
              @click="login"
            >Ingresar</v-btn>
            <div class="flex-grow-1"></div>
          </v-card-actions>
        </v-card>
    </section>

    <div class="Branch">
      <p class="Branch-text">Development by <a href="https://dark-aomine.nibbleframe.club/" target="_blank" class="Branch-link">aomine</a></p>
    </div>

    <div class="Fis-sky">
      <div class="Fis-wave"></div>
      <div v-for="(n, index) in starts" :class="`Star s${index + 1}`" :key="n"></div>
    </div>

    <div class="Fis">
      <div class="Fis-logoBox">
        <img src="../assets/login/fis.svg" alt="logo" class="Fis-logo">
      </div>
      <div class="Fis-waveBox">
        <div class="Fis-wave"></div>
      </div>
      <div v-for="n in 10" :class="`Star s${n}`" :key="n"></div>
    </div>
  </v-container>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  data () {
    return {
      // rules
      rules: {
        required: v => !!v || 'este campo es requerido.',
        email: v => /.+@.+/.test(v) || 'email no valido',
        password: v => v.length >= 8 || 'password debe tener mas de 8 caracteres'
      },
      // PAGE
      isLoading: true,
      starts: [11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
      // login
      email: '',
      password: '',
      // interaccion
      disabled: false,
      loadingBtn: false,
      show: false,
      session: false,
      // validacion
      valid: true,
      errorMsg: ''
    }
  },
  methods: {
    toogleInputs () {
      this.disabled = !this.disabled
      this.loadingBtn = !this.loadingBtn
    },
    async login () {
      if (!this.$refs.form.validate()) return

      try {
        const obj = {
          credentials: {
            email: this.email,
            password: this.password
          },
          session: this.session
        }
        this.toogleInputs()
        await this.setUser(obj)
      } catch (error) {
        this.errorMsg = 'Credenciales invalidas'
      } finally {
        this.toogleInputs()
      }
    },
    resetValidation () {
      this.errorMsg = ''
    },
    ...mapActions(['setUser'])
  },
  watch: {
    email () {
      if (this.errorMsg) {
        this.errorMsg = ''
      }
    },
    password () {
      if (this.errorMsg) {
        this.errorMsg = ''
      }
    }
  }
}
</script>

<style lang="scss" scoped>
@import '@/scss/styles.scss';

.Login {
  width: 400px;
  overflow: hidden;
  box-shadow: $shadow-large;
  @extend %card-aomine;
  @include desktop($bp-sm) {
    box-shadow: none;
  }
  /* &-card {
    background-color: $bg !important;
  } */
  &-title {
    color: #212121;
    opacity: .9;
    font-size: 24px;
    &-icon {
      color: #212121 !important;
      opacity: .9;
      transform: translateY(-2px)
    }
  }
}
.Branch {
  position: fixed;
  bottom: 8px;
  left: 20px;
  opacity: .45;
  transition: .3s;
  &:hover {
    opacity: .7;
  }
  &-link {
    text-decoration: none;
    &:hover {
      text-decoration: underline;
    }
  }
}
.Fis {
  position: fixed;
  bottom: 0;
  right: 0;
  width: 300px;
  height: 300px;
  &-logoBox {
    position: absolute;
    top: 50%;
    left: 40%;
    width: 120px;
    animation: fis 4.5s linear infinite;
    pointer-events: none;
    z-index: 4;
    &::before {
      content: '';
      position: absolute;
      top: 60px;
      left: 0;
      width: 30%;
      height: 60%;
      background-color: #607D8B;
      border-radius: 50%;
      filter: blur(15px);
      transform: rotate(45deg);
      opacity: .25;
      animation: fuel 5s linear infinite;
      z-index: 3;
      @keyframes fuel {
        0%{
          background-color: #2196F3;
          transform: rotate(45deg) scaleY(1);
        }
        25%{
          background-color: #FFEB3B;
        }
        50%{
          background-color: #607D8B;
          transform: rotate(45deg) scaleY(1.5);
        }
        75%{
          background-color: #03A9F4;
        }
        100%{
          background-color: #2196F3;
          transform: rotate(45deg) scaleY(1);
        }
      }
    }
    @keyframes fis {
      0%{
        transform: translate(-15px, -15px);
      }
      25%{
        transform: translate(15px, 0);
      }
      50%{
        transform: translate(-15px, 15px);
      }
      75%{
        transform: translate(15px, 0);
      }
      100%{
        transform: translate(-15px, -15px);
      }
    }
  }
  &-waveBox {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
  }
    &-sky {
    position: fixed;
    top: 0;
    left: 0;
    width: 300px;
    height: 300px;
    transform: translate(-35%, -35%) rotate(180deg);
    z-index: 1;
  }
  &-wave {
    background-image: url('../assets/login/waves3.svg');
    background-size: cover;
    background-repeat: repeat-x;
    background-position: left;
    width: 700px;
    height: 100%;
    animation: waves 1.5s infinite linear;
    transform: translate(-110px, 10px) rotate(-45deg);
    @keyframes waves {
      from{
        background-position: 0;
      }
      to{
        background-position: -175px;
      }
    }
  }
}
.Star {
	width: 2px;
	height: 2px;
	background: #fff;
	position: absolute;
	border-radius: 50%;
  transition: 0.5s;
  z-index: 2;
}
.s1 {
	top: 20%;
	left: 50%;
}
.s2 {
	top: 30%;
	left: 30%;
}
.s3 {
	top: 90%;
	left: 90%;
}
.s4 {
	top: 80%;
	left: 20%;
}
.s5 {
	top: 0%;
	left: 85%;
}
.s6 {
	top: 70%;
	left: 80%;
}
.s7 {
	top: 30%;
	left: 75%;
}
.s8 {
	top: 80%;
	left: 50%;
}
.s9 {
	top: 35%;
	left: 10%;
}
.s10 {
	top: 60%;
	left: 20%;
}
.s11 {
	top: 42%;
	left: 50%;
}
.Star:nth-child(2n) {
	animation: star-p 5s infinite;
}
.Star:nth-child(2n + 1) {
  animation: star-i 5s infinite;
  animation-delay: 5s;
}
@keyframes star-p {
	0%, 35%, 50%{
		box-shadow: 0 0 1px 1px rgba(255, 255, 255, 0.3);
	}
	45%{
		box-shadow: 0 0 2px 2px rgba(255, 255, 255, 0.3);
	}
}
@keyframes star-i {
	0%, 35%, 50%{
		box-shadow: 0 0 1px 1px rgba(255, 255, 255, 0.3);
	}
	45%{
		box-shadow: 0 0 2px 2px rgba(255, 255, 255, 0.3);
	}
}
</style>
