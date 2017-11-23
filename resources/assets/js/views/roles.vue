<template>
  <div>
    <data-table
      ref="table"
      :api-url="table.url"
      :fields="table.fields"
      :per-page="table.perPage"
      @vuetable:pagination-data="onPaginationData"
    >
      <template slot="actions" slot-scope="props">
        <div class="btn-group  btn-group-sm" v-if="canDataTable(props, 'permissions|users|update|delete')">
          <router-link v-if="canDataTable(props, 'permissions')" class="btn btn-secondary" :to="{ name: 'roles.permissions', params: { id: props.rowData.id } }">
            <i class="icon-checkmark"></i> Permisos
          </router-link>

          <router-link v-if="canDataTable(props, 'users')" class="btn btn-secondary" :to="{ name: 'roles.users', params: { id: props.rowData.id } }">
            <i class="icon-group"></i> Usuarios
          </router-link>

          <router-link v-if="canDataTable(props, 'update')" class="btn btn-secondary" :to="{ name: 'roles.edit', params: { id: props.rowData.id } }">
            <i class="icon-pen"></i> Editar
          </router-link>

          <button v-if="canDataTable(props, 'delete')" @click.prevent="deleteDataTable(props, 'roles')" class="btn btn-danger">
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

export default {
  mixins: [tableConfig],

  data () {
    return {
      table: {
        url: '/roles',
        fields: [
          {
            name: 'display_name',
            title: 'Nombre'
          },
          {
            name: 'description',
            title: 'Descripción'
          },
          {
            name: '__slot:actions',
            dataClass: 'data-table-actions'
          }
        ]
      }
    }
  }
}
</script>
