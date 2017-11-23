<template>
  <b-pagination
    v-if="table.pagination && table.pagination.last_page > 1"
    v-model="table.currentPage"
    :per-page="table.perPage"
    :align="table.paginationAlign"
    :total-rows="table.pagination.total"
    @change="onChangePage"
  />
</template>

<script>
export default {
  props: {
    table: {
      type: Object,
      required: true
    }
  },

  methods: {
    onChangePage (page) {
      this.$emit('change', page)
    }
  }
}
</script>
