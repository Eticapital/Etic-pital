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
      <template slot="project" slot-scope="props">
        {{ props.rowData.project.name }}
      </template>
      <template slot="amount" slot-scope="props">
        {{ props.rowData.amount / 100 | currency() }}
      </template>
      <template slot="date" slot-scope="props">
        {{ props.rowData.created_at | moment('l LT') }}
      </template>
      <template slot="status" slot-scope="props">
        <investments-status-btn :key="props.rowData.id" @deleted="deleted" :investment="props.rowData" />
      </template>
      <template slot="investor" slot-scope="props">
        {{ props.rowData.name }}<br>
        <div class="small">
        <a :href="'mailto: ' + props.rowData.email">{{ props.rowData.email }}</a><br>
        <template v-if="props.rowData.organization">
          {{ props.rowData.organization }}<br>
        </template>
        <template v-if="props.rowData.residence">
          {{ props.rowData.residence }}
        </template>
        </div><!-- /.small -->
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

import InvestmentsStatusBtn from '../components/InvestmentsStatusBtn.vue'

export default {
  components: {
    InvestmentsStatusBtn
  },

  mixins: [tableConfig],

  data () {
    return {
      table: {
        perPage: 15,
        url: '/investments',
        appendParams: {
          appends: [
            'can_update',
            'can_delete',
            'can_accept',
            'can_reject',
            'project',
          ]
        },
        fields: [
          {
            name: '__slot:project',
            title: 'Promesa'
          },
          {
            name: '__slot:amount',
            title: 'Monto'
          },
          {
            name: '__slot:date',
            title: 'Fecha'
          },
          {
            name: '__slot:investor',
            title: 'Inversionista'
          },
          {
            name: '__slot:status',
            title: 'Estatus'
          },
        ]
      }
    }
  },

  methods: {
    deleted (investment) {
      let index = this.table.pagination.data.findIndex(data => data.id === investment.id)
      // this.table.pagination.data.splice(index, 1)
      this.$refs.table.reload()
    }
  }
}
</script>
