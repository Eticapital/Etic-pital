<template>
  <b-card v-if="user" title="Datos de mi cuenta" class="card-table">
    <table class="table">
      <tr>
        <td>Nombre:</td>
        <td>{{ user.name }}</td>
      </tr>
      <tr>
        <td>Correo:</td>
        <td><a :href="'mailto:' + user.email">{{ user.email }}</a></td>
      </tr>
    </table><!-- /.table -->
  </b-card>
</template>

<script>
export default {
  data: function () {
    return {
      user: null
    }
  },

  beforeRouteEnter (to, from, next) {
    axios.get(App.basePath + 'account').then((response) => {
      next(vm => {
        vm.user = response.data
        bus.$emit('view-ready')
      })
    }).catch((error) => {
      console.log(error)
      next(false)
    })
  }
}
</script>
