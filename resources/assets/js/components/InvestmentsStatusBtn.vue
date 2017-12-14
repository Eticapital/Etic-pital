<template>
  <b-dropdown v-cloak size="sm" :variant="currentInvestment.status_class">
    <template slot="button-content">
      <template v-if="busy"><i class="icon-spinner spinner"></i> Actualizando</template>
      <template v-else><i :class="'icon-' + currentInvestment.status_icon"></i>{{ currentInvestment.status_label }}</template>
    </template>
    <b-dropdown-item :key="'accept-' + currentInvestment.id" @click.prevent="accept" v-if="currentInvestment.can_accept" class="text-success"><i class="icon-checkmark"></i> Aceptar</b-dropdown-item>
    <b-dropdown-item :key="'reject-' + currentInvestment.id" @click.prevent="reject" v-if="currentInvestment.can_reject" class="text-danger"><i class="icon-cross"></i> Rechazar</b-dropdown-item>
    <b-dropdown-item :key="'delete-' + currentInvestment.id" @click.prevent="doDelete" v-if="currentInvestment.can_delete" class="text-danger"><i class="icon-bin"></i> Eliminar</b-dropdown-item>
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
    },

    doDelete () {
      swal({
        title: '¿Estás seguro que deseas eliminar está promesa de inversión?',
        text: 'Esta acción no se puede deshacer',
        showCancelButton: true,
        confirmButtonText: 'Estoy seguro',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          this.busy = true
          return axios.delete(`/investments/${this.investment.id}`)
        }
      }).then((response) => {
        this.busy = false
        if (response.dismiss === 'cancel') {
          return
        }
        let investment = response.value.data
        this.$emit('deleted', investment)
        notify(`Inversión eliminado correctamente`)
      }).catch(errors => {
        console.log(errors)
        this.busy = false
        growl('Ocurrio un error inténtalo de nuevo o contacta al administrador.', 'danger')
      })
    }
  },
}
</script>