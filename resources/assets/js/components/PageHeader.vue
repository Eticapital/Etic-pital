<template>
    <div v-if="page_title||items.length" class="page-header hidden-sm-down">
        <b-breadcrumb :items="items"/>
        <!-- <header-search-form v-if="searchable"/> -->
        <!-- <h2 v-if="page_title" class="page-header-title">{{ page_title }}</h2> -->
    </div>
</template>

<script>
export default {
  data () {
    return {
      breadcrumbReady: false,
      items: [],
      page_title: '',
      searchable: ''
    }
  },

  computed: {
    params () {
      return bus.breadcrumbParams
    },

    attribs () {
      return bus.breadcrumbAttribs
    }
  },

  watch: {
    '$route.name': function (name) {
      this.updateBreadcrumb()
    }
  },

  mounted () {
    bus.$on('view-ready', () => {
      this.updateBreadcrumb()
    })

    bus.$on('nav-loaded', () => {
      Vue.nextTick(() => {
        this.updateBreadcrumb()
      })
    })
  },

  methods: {
    updateBreadcrumb () {
      let links = bus.breadcrumbLinks

      if (!links) {
        this.items = []
        this.page_title = ''
        this.searchable = ''
        bus.$emit('breadcrumb-updated')
        return false
      }

      let linksLength = links.length

      let data = links.map(function (value, i) {
        if (linksLength === i + 1) {
          return {
            active: true,
            text: format(value.text, bus.breadcrumbAttribs)
          }
        }

        let link = ''

        if (value.route) {
          link = router.resolve({
            name: value.route,
            params: bus.breadcrumbParams
          }).location.path
        } else {
          link = value.href
        }
        return {
          to: link,
          text: format(value.text, this.attribs)
        }
      }.bind(this))

      data.unshift({
        to: '/',
        text: '<i class="icon-home"></i> ' + 'Inicio'
      })

      this.items = data
      this.page_title = bus.pageTitle
      this.searchable = bus.searchable

      bus.$emit('breadcrumb-updated', links)
    }
  }
}
</script>

<style lang="scss">
@import "resources/assets/sass/globals";

.page-header {
    background: $white;
    margin: 0 0 15px;
    // padding: 20px 35px;
    position: relative;
    .breadcrumb {
        margin: 0;
    }
}

.page-header-title {
    margin-bottom: 5px;
    font-family: 'Open Sans', sans-serif;
    font-weight: 300;
    letter-spacing: -1px;
    font-size: 28px;
    line-height: 36px;
}
</style>
