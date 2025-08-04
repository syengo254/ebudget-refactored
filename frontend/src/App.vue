<script setup lang="ts">
import { computed, onMounted, ref } from 'vue'

import DefaultLayout from './layouts/DefaultLayout.vue'
import ErrorBoundary from './components/ErrorBoundary.vue'
import RouterGuard from './router/RouterGuard.vue'
import { RouterView, useRoute } from 'vue-router'
import StaffLayout from './layouts/StaffLayout.vue'

const route = useRoute()

const pageStates = {
  CHECKING: 1,
  USERSTATE: 2,
  STAFFSTATE: 3,
}

const state = ref(pageStates.CHECKING)
const routeName = computed(() => route.fullPath)

const updateState = () => {
  state.value = routeName.value.includes('staff') ? pageStates.STAFFSTATE : pageStates.USERSTATE
}

onMounted(() => {
  setInterval(updateState, 100)
})
</script>

<template>
  <ErrorBoundary>
    <RouterGuard>
      <StaffLayout v-if="state === pageStates.STAFFSTATE" key="staff-layout">
        <RouterView />
      </StaffLayout>
      <DefaultLayout v-else-if="state === pageStates.USERSTATE" key="default-layout">
        <RouterView />
      </DefaultLayout>
      <div v-else key="blank-layout">
        <!-- checking state - blank page -->
      </div>
    </RouterGuard>
  </ErrorBoundary>
</template>
