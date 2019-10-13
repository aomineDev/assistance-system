<template>
  <div class="Loader d-flex justify-center align-center fill-height">
    <p class="Loader-img">FIS LOGO</p>
  </div>
</template>

<style lang="scss" scoped>
.Loader {
  position: fixed;
  left: 0;
  right: 0;
  /* background-color: #432874; */
  &-img {
    color: #fff;
    animation: latido 3s infinite;
  }
}
@keyframes latido {
 50% {
   opacity: .5;
 }
}
</style>
