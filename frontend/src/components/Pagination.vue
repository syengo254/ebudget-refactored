<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps({
  paginationHandler: { required: true, type: Function },
  meta: { required: true, type: Object },
})

const maxIterations = computed(() => (props.meta.last_page > 15 ? 15 : props.meta.last_page))
const currentPage = computed(() => props.meta.current_page)
const lastPage = computed(() => props.meta.last_page)

const handlePageLink = (page: number) => {
  if (page == currentPage.value || page < 1 || page > lastPage.value) return
  props.paginationHandler(page)
}
</script>

<template>
  <div class="pagination">
    <div class="summary">Showing {{ meta.from }} - {{ meta.to }} of {{ meta.total }} items</div>
    <a id="first" href="#" class="pagination-link" @click.prevent="handlePageLink(1)">|&lt;</a>
    <a
      v-if="currentPage > 1"
      id="previous"
      href="#"
      class="pagination-link"
      @click.prevent="handlePageLink(currentPage - 1)"
      >&lt;&lt;</a
    >
    <a
      v-for="n in maxIterations"
      id="current"
      :key="'page-link' + n"
      href="#"
      :class="'pagination-link' + (n == currentPage ? ' active' : '')"
      @click.prevent="handlePageLink(n)"
      >{{ n }}</a
    >
    <a
      v-if="currentPage < lastPage"
      id="next"
      href="#"
      class="pagination-link"
      @click.prevent="handlePageLink(currentPage + 1)"
      >&gt;&gt;</a
    >
    <a id="last" href="#" class="pagination-link" @click.prevent="handlePageLink(lastPage)">>|</a>
  </div>
</template>

<style scoped>
.pagination {
  display: inline-flex;
  column-gap: 0.5rem;
  align-items: center;
}

.pagination > div.summary {
  font-size: 0.9rem;
}

a.pagination-link {
  font-size: 0.9rem;
  text-decoration: none;
  background-color: rgb(51, 97, 224);
  color: white;
  padding: 0.2rem 0.3rem;
  border-radius: 3.5px;
  min-width: 1.6rem;
  text-align: center;
}

a.pagination-link.active {
  background-color: rgb(52, 76, 212);
}

/* @media screen and (max-width: 450px) {
  .pagination {
    max-width: 100%;
    display: flex;
    flex-direction: column;
  }
} */
</style>
