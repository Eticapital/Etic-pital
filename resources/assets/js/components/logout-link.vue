<template>
  <a @click.prevent="logout" href="#">
    <slot v-if="!busy"></slot>
    <span v-else><i class="icon-spinner spinner"></i> Cerrando sesión</span>
  </a>
</template>

<script>
export default {
  data () {
    return {
      busy: false
    }
  },
  methods: {
    logout () {
      this.busy = true
      axios.post('/logout')
        .then(response => {
          window.location.replace('/')
        })
    }
  }
}
</script>
