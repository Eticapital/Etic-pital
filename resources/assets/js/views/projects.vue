<template>
  <div>
    <div class="d-flex mb-3">
      <b-nav pills>
          <b-nav-item exact :to="{query: null}">Todos</b-nav-item>
          <b-nav-item exact :to="{query: { status: 'published'}}">Publicados</b-nav-item>
          <b-nav-item exact :to="{query: { status: 'unpublished'}}">En revisión</b-nav-item>
          <b-nav-item exact :to="{query: { status: 'rejected'}}">Rechazados</b-nav-item>
        </b-nav>
      <div class="d-flex">
        <div class="ml-3">
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
        <b-form-select
          class="ml-3"
          v-model="sector_id"
          :options="sectorsOptions"
        />
      </div>
    </div><!-- /.d-flex -->

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
      <template slot="status" slot-scope="props">
        <b-dropdown
          size="sm"
          :text="props.rowData.status"
          class="m-0"
          :variant="props.rowData.status_variant"
        >
          <b-dropdown-item v-if="canDataTable(props, 'publish')" @click.prevent="publish(props.rowData)">Publicar</b-dropdown-item>
          <b-dropdown-item v-if="canDataTable(props, 'reject')" @click.prevent="reject(props.rowData)">Rechazar</b-dropdown-item>
          <b-dropdown-item v-if="canDataTable(props, 'finish')" @click.prevent="finish(props.rowData)">Finalizar</b-dropdown-item>
        </b-dropdown>
      </template>
      <template slot="collected" slot-scope="props">
        {{ props.rowData.collected / 100 | currency('$', 0) | placeholder('-') }}
      </template>
      <template slot="goal" slot-scope="props">
        {{ props.rowData.goal / 100 | currency('$', 0) | placeholder('-') }}
      </template>
      <template slot="created_at" slot-scope="props">
        {{ props.rowData.created_at | moment('l LT') }}
      </template>
      <template slot="actions" slot-scope="props">
        <div class="btn-group  btn-group-sm" v-if="canDataTable(props, 'update|destroy')">

          <a
            v-if="canDataTable(props, 'update')"
            class="btn btn-primary"
            :href="'/projects/' + props.rowData.id + '/edit?return=admin'">
            <i class="icon-pen"></i>
          </a>

          <router-link v-if="canDataTable(props, 'show')" class="btn btn-primary" :to="{ name: 'projects.edit', params: { id: props.rowData.id } }">
            <i class="icon-eye"></i>
          </router-link>

          <!-- <router-link v-if="canDataTable(props, 'update')" class="btn btn-primary" :to="{ name: 'projects.edit', params: { id: props.rowData.id } }">
            <i class="icon-wrench"></i>
          </router-link> -->

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
import Datepicker from 'vuejs-datepicker'

export default {
  components: {
    Datepicker
  },

  mixins: [tableConfig],

  data () {
    return {
      from: this.$route.query.from ? moment(this.$route.query.from).toDate() : null,
      to: this.$route.query.to ? moment(this.$route.query.to).toDate() : null,
      sector_id: null,
      sectors: null,
      table: {
        url: '/projects',
        appendParams: {
          appends: [
            'can_update',
            'can_destroy',
            'can_show',
            'can_publish',
            'can_reject',
            'can_finish',
            'owner_name',
            'status',
            'collected',
            'goal',
            'status_variant'
          ],
          status: this.$route.query.status,
          from: this.$route.query.from ? moment(this.$route.query.from).toDate() : null,
          to: this.$route.query.to ? moment(this.$route.query.to).toDate() : null,
          sector: null
        },
        fields: [
          {
            name: '__slot:name',
            title: 'Nombre del proyecto',
            sortField: 'name'
          },
          {
            sortField: 'holder',
            name: 'holder',
            title: 'Titular'
          },
          {
            sortField: 'status',
            name: '__slot:status',
            title: 'Estatus'
          },
          {
            sortField: 'collected',
            name: '__slot:collected',
            title: 'Recaudado'
          },
          {
            sortField: 'goal',
            name: '__slot:goal',
            title: 'Meta'
          },
          {
            sortField: 'created_at',
            name: '__slot:created_at',
            title: 'Creado'
          },
          {
            name: '__slot:actions',
            dataClass: 'data-table-actions'
          }
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
    },
    sector_id (sector) {
      this.table.appendParams.sector = sector
      this.$refs.table.refresh()
    }
  },

  computed: {
    sectorsOptions () {
      if (!this.sectors) {
        return []
      }
      let options = this.sectors.map(sector => {
        return {
          value: sector.id,
          text: sector.label
        }
      })

      return  _.concat([{value: null, text: '- Sector -'}], options)
    }
  },

  created () {
    this.loadSectors()
  },

  methods: {
    loadSectors () {
      axios.get('/sectors')
        .then(response => {
          this.sectors = response.data
        })
    },
    publish (project) {
      swal({
        title: '¿Estás seguro que deseas publicar este proyecto?',
        showCancelButton: true,
        confirmButtonText: 'Estoy seguro',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return axios.put(`/projects/${project.id}/publish`)
        }
      }).then((response) => {
        if (response.dismiss === 'cancel') {
          return
        }

        project.status = response.value.data.status
        project.status_variant = response.value.data.status_variant
        notify(`Proyecto <strong>${project.name}</strong> publicado correctamente`)
      })
    },
    reject (project) {
      swal({
        title: '¿Estás seguro que deseas rechazar este proyecto?',
        showCancelButton: true,
        confirmButtonText: 'Estoy seguro',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return axios.put(`/projects/${project.id}/reject`)
        }
      }).then((response) => {
        if (response.dismiss === 'cancel') {
          return
        }

        project.status = response.value.data.status
        project.status_variant = response.value.data.status_variant
        notify(`Proyecto <strong>${project.name}</strong> rechazado correctamente`)
      })
    },
    finish (project) {
      swal({
        title: '¿Estás seguro que deseas finalizar este proyecto?',
        showCancelButton: true,
        confirmButtonText: 'Estoy seguro',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return axios.put(`/projects/${project.id}/finish`)
        }
      }).then((response) => {
        if (response.dismiss === 'cancel') {
          return
        }

        project.status = response.value.data.status
        project.status_variant = response.value.data.status_variant
        notify(`Proyecto <strong>${project.name}</strong> finalizado correctamente`)
      })
    }
  }
}
</script>
