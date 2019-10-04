<template>
  <div class="Loader">
    <v-progress-circular
      indeterminate
      class="Loader-rotate"
      size="60"
      width="4"
    ></v-progress-circular>
  </div>
</template>

<style lang="scss" scoped>
@import '@/scss/styles.scss';

.Loader {
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: $bg;
  z-index: 1;
  &-rotate {
    animation: hueRotate 4s infinite;
  }
}
@keyframes hueRotate {
  0% {
    color: #f44336;
  }
  25% {
    color: #9c27b0;
  }
  50% {
    color: #2196f3;
  }
  75% {
    color: #4caf50;
  }
  100% {
    color: #ffeb3b;
  }
}
</style>
