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
        <router-link v-if="canDataTable(props, 'show')" :to="{ name: 'projects.show', params: { id: props.rowData.id } }">
          {{ props.rowData.name }}
        </router-link>
        <template v-else>{{ props.rowData.name }}</template>
      </template>
      <template slot="actions" slot-scope="props">
        <div class="btn-group  btn-group-sm" v-if="canDataTable(props, 'update|destroy')">
          <router-link v-if="canDataTable(props, 'update')" class="btn btn-primary" :to="{ name: 'projects.edit', params: { id: props.rowData.id } }">
            <i class="icon-pen"></i> Editar
          </router-link>

          <button v-if="canDataTable(props, 'destroy')" @click.prevent="deleteDataTable(props, 'projects')" class="btn btn-danger">
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
        url: '/projects',
        appendParams: {
          appends: ['can_update', 'can_destroy', 'can_show', 'owner_name']
        },
        fields: [
          {
            name: '__slot:name',
            title: 'Nombre'
          },
          {
            name: 'holder',
            title: 'Titular'
          },
          {
            name: 'phone',
            title: 'Teléfono'
          },
          {
            name: 'email',
            title: 'Correo'
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
