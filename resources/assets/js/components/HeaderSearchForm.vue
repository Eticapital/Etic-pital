<template>
  <b-nav-form @submit.prevent="search">
    <b-input-group size="sm">
      <b-input-group-button>
        <b-button @click.prevent="search"><i class="icon-search"></i></b-button>
      </b-input-group-button>
      <b-form-input @keyup="search" v-model="query" type="text" placeholder="Buscar..." />
      <b-input-group-button v-if="query">
        <b-button variant="danger" @click.prevent="reset" ><i class="icon-cross"></i></b-button>
      </b-input-group-button>
    </b-input-group>
  </b-nav-form>
</template>

<script>
export default {
  data () {
    return {
      query: ''
    }
  },

  watch: {
    '$route': function () {
      this.query = ''
    }
  },

  created () {
    bus.$on('header-query-clear', () => {
      this.reset()
    })
  },

  watch: {
    query (query) {
      this.search()
    }
  },

  methods: {
    search () {
      bus.$emit('header-query-set', this.query)
    },

    reset () {
      this.query = ''
      bus.$emit('header-query-reset', this.query)
    }
  }
}
</script>
