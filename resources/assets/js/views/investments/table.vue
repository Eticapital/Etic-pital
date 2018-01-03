<template>
  <div>
    <div class="d-flex mb-3">
      <div class="d-flex">
        <div>
          <datepicker
            :bootstrap-styling="true"
            placeholder="Desde:"
            v-model="from"
            :clear-button="true"
            language="es"
          />
        </div>
        <div class="ml-3">
          <datepicker
            :bootstrap-styling="true"
            placeholder="Hasta:"
            v-model="to"
            :clear-button="true"
            language="es"
          />
        </div>
      </div>

      <b-nav pills class="ml-auto">
        <b-nav-item exact :to="{query: null}">Todos</b-nav-item>
        <b-nav-item exact :to="{query: { status: 1}}">Aceptadas</b-nav-item>
        <b-nav-item exact :to="{query: { status: 0}}">Pendientes</b-nav-item>
        <b-nav-item exact :to="{query: { status: -1}}">Rechazadas</b-nav-item>
      </b-nav>
    </div>

    <data-table
      ref="table"
      :api-url="table.url"
      :fields="table.fields"
      :append-params="table.appendParams"
      :per-page="table.perPage"
      @vuetable:pagination-data="onPaginationData"
    >
      <template slot="project" slot-scope="props">
        <router-link v-if="can(props.rowData.project, 'show')" :to="{ name: 'projects.show', params: { id: props.rowData.project.id } }">
          {{ props.rowData.project.name }}
        </router-link>
        <template v-else>{{ props.rowData.project.name }}</template>
      </template>
      <template slot="owner" slot-scope="props">
        <router-link v-if="can(props.rowData.owner, 'show')" :to="{ name: 'users.show', params: { id: props.rowData.owner.id } }">
          {{ props.rowData.owner.name }}
        </router-link>
        <template v-else>{{ props.rowData.owner.name }}</template>
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
import { tableConfig } from '../../mixins.js'

import InvestmentsStatusBtn from '../../components/InvestmentsStatusBtn.vue'
import Datepicker from 'vuejs-datepicker'

export default {
  components: {
    InvestmentsStatusBtn,
    Datepicker
  },

  mixins: [tableConfig],

  props: {
    project: {
      type: Object,
      required: false
    },
    perPage: {
      type: Number,
      default: 15
    }
  },

  data () {
    return {
      to: null,
      from: this.$route.query.from ? moment(this.$route.query.from).toDate() : null,
      to: this.$route.query.to ? moment(this.$route.query.to).toDate() : null,
      table: {
        perPage: this.perPage,
        url: '/investments',
        appendParams: {
          appends: [
            'can_update',
            'can_delete',
            'can_accept',
            'can_reject',
            'project',
            'project.can_show',
            'owner',
            'owner.can_show'
          ],
          status: this.$route.query.status,
          project: this.project ? this.project.id : null,
          from: this.$route.query.from ? moment(this.$route.query.from).toDate() : null,
          to: this.$route.query.to ? moment(this.$route.query.to).toDate() : null,
        },
        fields: [
          {
            name: '__slot:project',
            title: 'Proyecto',
            sortField: 'project'
          },
          {
            name: '__slot:amount',
            title: 'Monto',
            sortField: 'amount'
          },
          {
            name: '__slot:date',
            title: 'Fecha',
            sortField: 'created_at'
          },
          {
            name: '__slot:investor',
            title: 'Inversionista',
            sortField: 'name'
          },
          {
            name: '__slot:owner',
            title: 'Usuario',
            sortField: 'owner'
          },
          {
            name: '__slot:status',
            title: 'Estatus',
            sortField: 'status'
          },
        ]
      }
    }
  },

  watch: {
    '$route.query' (query) {
      this.table.appendParams.status = query.status
      this.$refs.table.refresh()
    },
    from (from) {
      this.table.appendParams.from = from
      this.$refs.table.refresh()
    },
    to (to) {
      this.table.appendParams.to = to
      this.$refs.table.refresh()
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
