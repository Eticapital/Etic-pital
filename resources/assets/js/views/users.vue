<template>
  <div>
    <data-table
      ref="table"
      :api-url="table.url"
      :fields="table.fields"
      :append-params="table.appendParams"
      :per-page="table.perPage"
      @vuetable:pagination-data="onPaginationData"
    >
      <template slot="name" slot-scope="props">
        <router-link v-if="canDataTable(props, 'show')" :to="{ name: 'users.show', params: { id: props.rowData.id } }">
          {{ props.rowData.name }}
        </router-link>
        <template v-else>{{ props.rowData.name }}</template>
      </template>
      <template slot="status" slot-scope="props">
        <users-status-link :user="props.rowData" @status-updated="statusUpdated" />
      </template>
      <template slot="actions" slot-scope="props">
        <div class="btn-group  btn-group-sm" v-if="canDataTable(props, 'update|destroy')">
          <router-link v-if="canDataTable(props, 'show')" class="btn btn-primary" :to="{ name: 'users.show', params: { id: props.rowData.id } }">
            <i class="icon-eye"></i> Ver
          </router-link>

          <router-link v-if="canDataTable(props, 'update')" class="btn btn-primary" :to="{ name: 'users.edit', params: { id: props.rowData.id } }">
            <i class="icon-pen"></i> Editar
          </router-link>

          <button v-if="canDataTable(props, 'destroy')" @click.prevent="deleteDataTable(props, 'users')" class="btn btn-danger">
            <i class="icon-bin"></i>
          </button>
        </div>
      </template>
    </data-table>

    <data-table-pagination
      class="mt-3"
      :table="table"
      @change="onChangePage"
    />
  </div>
</template>

<script>
import { tableConfig } from '../mixins.js'
import UsersStatusLink from './users/_users_status_link'

export default {
  components: {
    UsersStatusLink
  },

  mixins: [tableConfig],

  data () {
    return {
      table: {
        url: '/users',
        appendParams: {
          appends: ['can_update', 'can_destroy', 'can_show']
        },
        fields: [
          {
            name: '__slot:name',
            title: 'Nombre'
          },
          {
            name: 'email',
            title: 'Correo electrónico'
          },
          {
            name: '__slot:status',
            dataClass: 'data-table-statuss'
          },
          {
            name: '__slot:actions',
            dataClass: 'data-table-actions'
          }
        ]
      }
    }
  },

  methods: {
    statusUpdated (newUser) {
      let user = this.table.pagination.data.find(user => newUser.id === user.id)
      user.is_published = newUser.is_published
    }
  }
}
</script>
