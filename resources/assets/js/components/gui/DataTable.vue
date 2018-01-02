<script>
import { Vuetable } from 'vuetable-2';

import axios from 'axios'
import axiosCancel from 'axios-cancel';
axiosCancel(axios);

export default {
  extends: Vuetable,

  props: {
    noDataTemplate: {
      type: String,
      default() {
        return 'No se encontraron datos'
      }
    },

    paginationPath: {
        type: [String],
        default: ''
    },

    requestId: {
      required: false,
      default: 'data-table'
    },

    css: {
      type: Object,
      default () {
        return {
          tableClass: 'table table-striped table-bordered',
          loadingClass: 'loading',
          ascendingIcon:  'icon-sort-asc',
          descendingIcon: 'icon-sort-desc',
          ascendingClass: 'sorted-asc',
          descendingClass: 'sorted-desc',
          sortableIcon:   'icon-sort',
          detailRowClass: 'vuetable-detail-row',
          handleIcon: 'icon-menu',
          tableBodyClass: 'vuetable-semantic-no-top vuetable-fixed-layout',
          tableHeaderClass: 'vuetable-fixed-layout'
        }
      }
    }
  },

  data ()  {
    return {
      query: null,
    }
  },

  // watch: {
  //   sortOrder (sortOrder) {
  //     let query = _.merge(this.$route.query, {sort: sortOrder[0].sortField + '|' + sortOrder[0].direction})
  //     this.$router.replace({query: null})
  //     this.$router.replace({query: query})
  //   }
  // },

  created () {
    bus.$on('header-query-set', (query) => {
      this.query = query
      this.loadData()
    })
  },

  methods: {
    getAllQueryParams () {
      let params = {}
      params[this.queryParams.sort] = this.getSortParam()
      params[this.queryParams.page] = this.currentPage
      params[this.queryParams.perPage] = this.perPage

      for (let x in this.appendParams) {
        params[x] = this.appendParams[x]
      }

      params['query'] = this.query

      return params
    },

    loadFailed (response) {
      if (!axios.isCancel(response)) {
        console.error('load-error', response)
        this.fireEvent('load-error', response)
      } else {
        this.fireEvent('load-canceled', response)
      }

      this.fireEvent('loaded')
    },

    fetch (apiUrl, httpOptions) {
      httpOptions['requestId'] = this.requestId
      return this.httpFetch
        ? this.httpFetch(apiUrl, httpOptions)
        : axios[this.httpMethod](apiUrl, httpOptions)
    }
  }
}
</script>
