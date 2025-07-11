<script setup lang="ts">
import { PropType } from 'vue'
import GroupBaseLayout from './GroupBaseLayout.vue'
import GroupBody from './GroupBody.vue'

import GroupHeader from './GroupHeader.vue'
import { GroupingType } from '../../types'
import ErrorBoundary from '../ErrorBoundary.vue'

defineProps({
  heading: {
    type: String,
    required: true,
  },
  grouping: {
    type: Object as PropType<GroupingType>,
    required: true,
  },
})
</script>

<template>
  <ErrorBoundary :is-page="false">
    <GroupBaseLayout>
      <template #header>
        <GroupHeader>{{ heading.charAt(0).toUpperCase() + heading.slice(1).toLowerCase() }}</GroupHeader>
      </template>
      <template #body>
        <GroupBody :filter="grouping" />
      </template>
      <!--<template #footer> footer </template> -->
    </GroupBaseLayout>
  </ErrorBoundary>
</template>

<style scoped>
.group-container > div {
  background-color: white;
  margin-inline: 1.5rem;
}
</style>
