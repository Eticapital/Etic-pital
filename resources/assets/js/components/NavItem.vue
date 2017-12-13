<template>
  <b-nav-item v-if="!hasDropdown" :to="to" :href="href">
    <i v-if="hasIcon" :class="'icon icon-' + link.icon"></i>
    {{link.text}}
    <b-badge v-if="link.notifications" v-text="link.notifications"/>
  </b-nav-item>
  <b-nav-item-dropdown v-else>
    <template slot="button-content">
      <i v-if="hasIcon" :class="'icon icon-' + link.icon"></i>
      {{link.text}}
      <b-badge v-if="link.notifications" v-text="link.notifications"/>
    </template>

    <nav-item
      v-for="(link, index) in link.items"
      :link="link"
      :index="index"
      :key="index"
    />
  </b-nav-item-dropdown>
</template>

<script>
export default {
  name: 'nav-item',

  props: {
    'link': null,
    'index': null,
    'element-name': {
      default: 'nav-link'
    }
  },

  computed: {
    to () {
      if (this.link.route) {
        return { name: this.link.route, params: this.link.params }
      }

      return null
    },

    href () {
      if (this.link.href) {
        return format(this.link.href, bus.breadcrumbParams)
      }

      return null
    },

    id () {
      if (this.link.id) {
        return this.link.id
      }

      // Si tiene dropdown necesita un id para el atributo aria-labelledby
      if (this.hasDropdown) {
        return this.elementName + '-' + (parseInt(this.index) + 1).toString()
      }

      return null
    },

    hasDropdown () {
      return this.link.items && this.link.items.length > 0
    },

    hasIcon () {
      return this.link.icon
    }
  },

  created () {
    bus.$on('main-navbar-dropdown-open', (el) => {
      if (this.open && el !== this) {
        this.open = false
      }
    })
  }
}
</script>
