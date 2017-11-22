<template>
  <ul v-if="tablePagination && tablePagination.last_page > 1" :class="css.wrapperClass">
    <li
      :class="[css.linkClass, isOnFirstPage ? css.disabledClass : '']">
      <a @click.prevent="loadPage(1)" class="page-link" href="">
        <i v-if="css.icons.first != ''" :class="[css.icons.first]"></i>
        <span v-else>&laquo;</span>
      </a>
    </li>
    <li
      :class="[css.linkClass, isOnFirstPage ? css.disabledClass : '']">
      <a @click.prevent="loadPage('prev')" class="page-link" href="">
        <i v-if="css.icons.next != ''" :class="[css.icons.prev]"></i>
        <span v-else>&nbsp;&lsaquo;</span>
      </a>
    </li>
    <template v-if="notEnoughPages">
      <template v-for="n in totalPage">
        <li
          :class="[css.pageClass, isCurrentPage(n) ? css.activeClass : '']"
          >
          <a @click.prevent="loadPage(n)"class="page-link" href="" v-html="n"></a>
        </li>
      </template>
    </template>
    <template v-else>
      <template v-for="n in windowSize">
        <li
          :class="[css.pageClass, isCurrentPage(windowStart+n-1) ? css.activeClass : '']"
          >
          <a href="" class="page-link"  @click.prevent="loadPage(windowStart+n-1)" v-html="windowStart+n-1"></a>
        </li>
      </template>
    </template>
    <li
      :class="[css.linkClass, isOnLastPage ? css.disabledClass : '']">
      <a  @click.prevent="loadPage('next')" class="page-link" href="">
        <i v-if="css.icons.next != ''" :class="[css.icons.next]"></i>
        <span v-else>&rsaquo;&nbsp;</span>
      </a>
    </li>
    <li
      :class="[css.linkClass, isOnLastPage ? css.disabledClass : '']">
      <a @click.prevent="loadPage(totalPage)"class="page-link" href="">
        <i v-if="css.icons.last != ''" :class="[css.icons.last]"></i>
        <span v-else>&raquo;</span>
      </a>
    </li>
  </ul>
</template>

<script>

import PaginationMixin from '../../../../../node_modules/vuetable-2/src/components/VuetablePagination.vue'

export default {
  props: {
    css: {
      type: Object,
      default () {
        return {
          wrapperClass: 'pagination',
          activeClass: 'active',
          disabledClass: 'disabled',
          pageClass: 'page-item',
          linkClass: 'page-item',
          paginationClass: '',
          paginationInfoClass: '',
          dropdownClass: '',
          icons: {
            first: '',
            prev: '',
            next: '',
            last: '',
          }
        }
      }
    },
  },
  mixins: [PaginationMixin],
}
</script>
