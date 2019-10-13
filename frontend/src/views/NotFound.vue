<template>
  <v-container class="d-flex align-center justify-center fill-height">
    <div class="text-center">
      <h1 class="Notfound-404">404</h1>
      <h2 class="py-2">Not Found</h2>
      <p>La página que buscas no esta disponible</p>
      <v-btn
        text
        color="blue"
        to="/"
        rounded
      >Volver</v-btn>
    </div>
  </v-container>
</template>

<style lang="scss" scoped>
.Notfound {
  &-404 {
    font-size: 80px;
    animation: bounce .5s infinite;
  }
}
@keyframes bounce {
  50% {
    transform: scale(1.2)
  }
}
</style>
