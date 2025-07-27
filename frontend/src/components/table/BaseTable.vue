<script setup lang="ts"></script>

<template>
  <table>
    <caption class="text-sm">
      <p style="margin: 0; margin-bottom: 0.5rem; font-style: italic">
        <slot name="caption">
          <!-- children go here -->
        </slot>
      </p>
    </caption>
    <thead>
      <tr>
        <slot name="thead">
          <!-- children go here -->
        </slot>
      </tr>
    </thead>
    <tbody>
      <slot name="tbody">
        <!-- children go here -->
      </slot>
    </tbody>
    <tfoot>
      <tr>
        <slot name="tfoot">
          <!-- children go here -->
        </slot>
      </tr>
    </tfoot>
  </table>
</template>

<style scoped>
/* Table Styles */
table {
  width: 100%;
  border-collapse: collapse;
}

:slotted(table.rounded thead th:first-of-type) {
  border-top-left-radius: 10px;
}
:slotted(table.rounded thead th:last-of-type) {
  border-top-right-radius: 10px;
}
:slotted(table.rounded tfoot tr:last-of-type th:first-of-type) {
  border-bottom-left-radius: 10px;
}
:slotted(table.rounded tfoot tr:last-of-type td:last-of-type) {
  border-bottom-right-radius: 10px;
}

:slotted(table.stripped > tbody > tr:nth-child(even)) {
  background-color: #f3f4ff;
}

thead > tr {
  background-color: var(--bg-blue);
  color: white;
}

tfoot > tr {
  background-color: var(--bg-light-blue);
  color: white;
}

:slotted(thead > tr > th) {
  font-size: 1rem;
  font-weight: 500;
  padding: 0.4rem 0.8rem;
  width: auto;
}

:slotted(tfoot > tr > th),
:slotted(tfoot > tr > td) {
  font-size: 1rem;
  font-weight: 600;
  padding: 0.3rem 0.8rem;
  width: auto;
  text-transform: uppercase;
}

:slotted(tbody > tr > td) {
  padding: 0.4rem 0.6rem;
  font-size: 0.92rem;
  letter-spacing: 0.3px;
}

/* tbody > tr > td:first-of-type {
  border-left: 1px solid var(--bg-light-blue);
}
tbody > tr > td:last-of-type {
  border-right: 1px solid var(--bg-light-blue);
} */

:slotted(th.right),
:slotted(td.right) {
  text-align: right;
}

:slotted(th.center),
:slotted(td.center) {
  text-align: center;
}

:slotted(th.left),
:slotted(td.left) {
  text-align: left;
}
</style>
