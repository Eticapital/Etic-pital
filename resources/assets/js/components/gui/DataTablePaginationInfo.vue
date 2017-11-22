<template>
  <div :class="['vuetable-pagination-info', css.infoClass]"
    v-html="paginationInfo">
  </div>
</template>

<script>
import PaginationInfoMixin from '../../../../../node_modules/vuetable-2/src/components/VuetablePaginationInfoMixin.vue'

export default {
  mixins: [PaginationInfoMixin],
  props: {
    css: {
      type: Object,
      default() {
        return {
          infoClass: 'hidden-md-down'
        }
      }
    },
    infoTemplate: {
      type: String,
      default() {
        return "Mostrando de {from} a {to} de un total de {total} elementos"
      }
    },
    noDataTemplate: {
      type: String,
      default() {
        return ''
      }
    },
  },
}
</script>
