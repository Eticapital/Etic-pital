<template>
  <div v-if="user">
  <b-card title="Datos del usuario" class="card-table">
    <table class="table">
      <tr>
        <td>Estatus:</td>
        <td>
          <users-status-link :user="user" @status-updated="statusUpdated" />
        </td>
      </tr>
      <tr>
        <td>Nombre:</td>
        <td>{{ user.name }}</td>
      </tr>
      <tr>
        <td>Correo:</td>
        <td><a :href="'mailto:' + user.email">{{ user.email }}</a></td>
      </tr>
      <tr>
        <td>Grupos:</td>
        <td>{{ user.roles_list || '-Ninguno-' }}</td>
      </tr>
      <tr>
        <td>Teléfono:</td>
        <td>{{ user.phone }}</td>
      </tr>
      <tr>
        <td>Organización:</td>
        <td>{{ user.organization }}</td>
      </tr>
      <tr>
        <td>Residencia:</td>
        <td>{{ user.residence }}</td>
      </tr>
    </table><!-- /.table -->
  </b-card>

  <b-card title="Inversiones" class="mt-3">
    <investments-table :per-page="5" :user="user" />
  </b-card>
  </div>

</template>

<script>
import UsersStatusLink from './_users_status_link'
import InvestmentsTable from '../investments/investments-table'

export default {
  components: {
    UsersStatusLink,
    InvestmentsTable
  },

  data: function () {
    return {
      user: null
    }
  },

  beforeRouteEnter (to, from, next) {
    let params = {
      appends: ['roles_list']
    }
    axios.get(App.basePath + 'users/' + to.params.id, {params:params}).then((response) => {
      next(vm => {
        vm.user = response.data
        bus.breadcrumbParams = { id: vm.user.id }
        bus.breadcrumbAttribs = { name: vm.user.name }
        bus.$emit('view-ready')
      })
    }).catch((error) => {
      console.log(error)
      next(false)
    })
  },

  methods: {
    statusUpdated (user) {
      this.user = user
    }
  }
}
</script>
