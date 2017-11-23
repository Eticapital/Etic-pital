let tableConfig = {
  data () {
    return {
      table: {
        query: null,
        currentPage: 1,
        perPage: 10,
        paginationAlign: 'center',
        pagination: null,
      }
    }
  },

  methods: {
    onPaginationData (paginationData) {
      this.table.pagination = paginationData;
    },

    onChangePage (page) {
      this.$refs.table.changePage(page)
    }
  }
}

let dropdownMixins = {
  data: function () {
    return {
      toggleFlag: null
    }
  },

  methods: {
    toggleDropdown: function (toggleFlag, force = null) {
      this.toggleFlag = toggleFlag
      this[toggleFlag] = force == null ? !this[toggleFlag] : force
      if (this[toggleFlag]) {
        bus.$emit('dropdown-toggle-open', this)
      }
    }
  },

  created () {
    // Cuando se ejecute este método debe de asegurarse de cerrar cualquier otro dropdown
    bus.$on('dropdown-toggle-open', function (emitter) {
      if (this != emitter) {
        this.toggleDropdown(this.toggleFlag, false)
      }
    }.bind(this))
  }
}

module.exports = {
  'dropdownMixins': dropdownMixins,
  'tableConfig': tableConfig
}
