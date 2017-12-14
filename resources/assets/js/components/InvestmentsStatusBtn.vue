<template>
  <b-dropdown v-cloak size="sm" :variant="currentInvestment.status_class">
    <template slot="button-content">
      <template v-if="busy"><i class="icon-spinner spinner"></i> Actualizando</template>
      <template v-else><i :class="'icon-' + currentInvestment.status_icon"></i>{{ currentInvestment.status_label }}</template>
    </template>
    <b-dropdown-item @click.prevent="accept" v-if="currentInvestment.can_accept" class="text-success"><i class="icon-checkmark"></i> Aceptar</b-dropdown-item>
    <b-dropdown-item @click.prevent="reject" v-if="currentInvestment.can_reject" class="text-danger"><i class="icon-cross"></i> Rechazar</b-dropdown-item>
  </b-dropdown>
</template>

<script>
export default {
  data () {
    return {
      busy: false,
      currentInvestment: this.investment
    }
  },

  props: {
    user: Object,
    investment: Object
  },

  methods: {
    accept () {
      this.busy = true
      axios.post(`/investments/${this.investment.id}/accept`)
        .then(response => {
          this.currentInvestment = response.data
          this.busy = false
          growl('Estatus actualizado correctamente')
        })
        .catch(errors => {
          console.log(errors)
          this.busy = false
          growl('Ocurrio un error inténtalo de nuevo o contacta al administrador.', 'danger')
        })
    },

    reject () {
      this.busy = true
      axios.post(`/investments/${this.investment.id}/reject`)
        .then(response => {
          this.currentInvestment = response.data
          this.busy = false
          growl('Estatus actualizado correctamente')
        })
        .catch(errors => {
          console.log(errors)
          this.busy = false
          growl('Ocurrio un error inténtalo de nuevo o contacta al administrador.', 'danger')
        })
    }
  },
}
</script>