<script setup lang="ts">
import { PropType } from 'vue'
import useToast from '../composables/useToast'

defineProps({
  position: {
    type: String as PropType<'top' | 'bottom' | 'center'>,
    required: false,
    default: 'top',
  },
})

const { toastQueue } = useToast()
</script>

<template>
  <Teleport to="body">
    <div :class="'toast-group ' + position">
      <TransitionGroup name="toast-transition">
        <div v-for="toast in toastQueue" :key="toast.message" :class="'toast ' + toast.variant">
          {{ toast.read() }}
        </div>
      </TransitionGroup>
    </div>
  </Teleport>
</template>

<style scoped>
.toast-group {
  display: flex;
  z-index: 200;
  position: fixed;
  left: calc(50% - 200px);
  width: 400px;
  height: auto;
  flex-direction: column;
  row-gap: 1rem;
  background: transparent;
}

.toast {
  font-size: 0.95rem;
  font-weight: 400;
  text-align: center;
  padding: 0.4rem 1.2rem;
  border-radius: 5px;
  box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
  width: inherit;
  opacity: 0.8;
}

.toast-group.top {
  top: 120px;
}
.toast-group.bottom {
  bottom: 20px;
}
.toast-group.center {
  top: 50vh;
}

/* variants */

.info {
  color: #004085;
  background-color: #cce5ff;
  border-color: #b8daff;
}

.error {
  color: #721c24;
  background-color: #f8d7da;
  border-color: #f5c6cb;
}

.warning {
  color: #856404;
  background-color: #fff3cd;
  border-color: #ffeeba;
}

.success {
  color: #155724;
  background-color: #d4edda;
  border-color: #c3e6cb;
}
/* variants */

/* transition classes */
.toast-transition-enter-from {
  opacity: 0;
  /* transform: translateY(300px); */
}

.toast-transition-leave-to {
  opacity: 0;
  /* transform: translateY(-30px); */
}

.toast-transition-enter-to,
.toast-transition-leave-from {
  opacity: 1;
}

.toast-transition-leave-active {
  transition: all 200ms ease-in;
}
.toast-transition-enter-active {
  animation: wobble 0.3s ease;
}

@keyframes wobble {
  60% {
    transform: translate(6px);
  }
  70% {
    transform: translate(-6px);
  }
  80% {
    transform: translate(3px);
  }
  90% {
    transform: translate(-3px);
  }
  100% {
    transform: translate(0px);
  }
}
</style>
