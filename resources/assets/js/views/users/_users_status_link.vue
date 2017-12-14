<template>
  <a
    :class="{'text-success': user.is_published, 'text-danger': !user.is_published}"
    href="#"
    @click.prevent="toggleStatus"
  >
    <template v-if="busy"><i class="icon-spinner spinner"></i></template>
    <template v-else-if="user.is_published">Activo</template>
    <template v-else>Inactivo</template>
  </a>
</template>

<script>
export default {
  props: {
    user: Object
  },

  data() {
    return {
      busy: false
    }
  },

  methods: {
    toggleStatus () {
      this.busy = true
      axios.post(`/users/${this.user.id}/status`)
        .then(response => {
          this.$emit('status-updated', response.data)
          this.busy = false
        })
        .catch(errors => {
          console.log(errors)
          this.busy = false
          swal('Ocurrió un error, inténtalo de nuevo o contacta al administrador.')
        })
    }
  }
}
</script>