<script setup lang="ts">
const props = defineProps({
  paginationHandler: { required: true, type: Function },
  meta: { required: true, type: Object },
})

const handlePageLink = (page: number) => {
  if (page == props.meta.current_page || page < 1 || page > props.meta.last_page) return
  props.paginationHandler(page)
}
</script>

<template>
  <div class="pagination">
    <div class="summary">Showing {{ meta.from }} - {{ meta.to }} of {{ meta.total }} items</div>
    <a id="first" href="#" class="pagination-link" @click.prevent="handlePageLink(1)">|&lt;</a>
    <a
      v-if="meta.current_page > 1"
      id="previous"
      href="#"
      class="pagination-link"
      @click.prevent="handlePageLink(meta.current_page - 1)"
      >&lt;&lt;</a
    >
    <a
      v-for="n in meta.last_page"
      id="current"
      :key="'page-link' + n"
      href="#"
      :class="'pagination-link' + (n == meta.current_page ? ' active' : '')"
      @click.prevent="handlePageLink(n)"
      >{{ n }}</a
    >
    <a
      v-if="meta.current_page < meta.last_page"
      id="next"
      href="#"
      class="pagination-link"
      @click.prevent="handlePageLink(meta.current_page + 1)"
      >&gt;&gt;</a
    >
    <a id="last" href="#" class="pagination-link" @click.prevent="handlePageLink(meta.last_page)">>|</a>
  </div>
</template>

<style scoped>
.pagination {
  display: inline-flex;
  column-gap: 0.3rem;
  margin-block: 0.5rem;
  align-items: center;
  justify-content: flex-end;
  padding-inline: 0.5rem;
}

.pagination > div.summary {
  font-size: 0.9rem;
  margin-inline: 0.5rem;
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
</style>
