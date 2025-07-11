<template>
  <div class="loader-wrapper">
    <div class="loader">
      <!-- Loading products, please wait... -->
    </div>
  </div>
</template>

<style scoped>
.loader-wrapper {
  position: absolute;
  left: 50%;
  top: 30%;
}
/* HTML: <div class="loader"></div> */
.loader {
  width: 50px;
  aspect-ratio: 1;
  display: grid;
  border: 4px solid #0000;
  border-radius: 50%;
  border-color: #ccc #0000;
  animation: l16 1s infinite linear;
}
.loader::before,
.loader::after {
  content: '';
  grid-area: 1/1;
  margin: 2px;
  border: inherit;
  border-radius: 50%;
}
.loader::before {
  border-color: #2f4cdd #0000;
  animation: inherit;
  animation-duration: 0.5s;
  animation-direction: reverse;
}
.loader::after {
  margin: 8px;
}
@keyframes l16 {
  100% {
    transform: rotate(1turn);
  }
}
/* .loader {
  width: 120px;
  height: 20px;
  background: linear-gradient(90deg, #0001 33%, #0005 50%, #0001 66%) #f2f2f2;
  background-size: 300% 100%;
  animation: l1 1s infinite linear;
}
@keyframes l1 {
  0% {
    background-position: right;
  }
} */
</style>
