<script setup lang="ts">
import BaseButton from '../buttons/BaseButton.vue'

defineEmits(['cancel', 'confirmed'])
defineProps({
  open: {
    type: Boolean,
    required: true,
  },
})
</script>

<template>
  <Teleport to="body">
    <div v-if="open" class="backdrop">
      <div class="modal dialog">
        <div class="head">
          <p>Confirm product deletion</p>
        </div>
        <div class="body">
          <p>Do you wish to proceed?</p>
        </div>
        <div class="footer">
          <div class="footer-buttons">
            <BaseButton variant="outlined" style="border-radius: 3.5px; font-size: 1rem" @click="$emit('cancel')"
              >Cancel</BaseButton
            >
            <BaseButton @click="$emit('confirmed')">Confirm</BaseButton>
          </div>
        </div>
      </div>
    </div>
  </Teleport>
</template>

<style scoped>
/* modal */
.modal {
  position: fixed;
  z-index: 200;
  top: 30%;
  left: 50%;
  --color-black: rgb(43, 43, 43);
  color: var(--color-black);
}

.modal.dialog {
  --dialog-radius: 7px;
  width: 600px;
  height: fit-content;
  background-color: white;
  margin-left: calc(-600px / 2);
  border-radius: var(--dialog-radius);
  border: 1px solid transparent;
}

.modal > .head {
  text-transform: capitalize;
  background: rgb(240, 240, 240);
  border-radius: var(--dialog-radius) var(--dialog-radius) 0px 0px;
}

.modal > .head > p,
.modal > .head > h4 {
  margin: 0;
  padding: 1rem;
  font-weight: 500;
  font-size: 1.2rem;
  color: var(--color-black);
}

.modal .body {
  padding: 0.5rem 1rem;
  font-size: 1rem;
}

.modal > div.footer {
  padding: 0.5rem 1rem;
  background: rgb(240, 240, 240);
  border-radius: 0px 0px var(--dialog-radius) var(--dialog-radius);
}

.modal > div.footer .footer-buttons {
  display: flex;
  justify-content: space-between;
}

.backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.4);
  z-index: 99;
}
</style>
