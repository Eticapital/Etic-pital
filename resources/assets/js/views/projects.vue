<template>
  <div>
    <b-nav pills class="mb-3">
      <b-nav-item exact disabled>Estatus:</b-nav-item>
      <b-nav-item exact :to="{query: null}">Todos</b-nav-item>
      <b-nav-item exact :to="{query: { status: 'published'}}">Publicados</b-nav-item>
      <b-nav-item exact :to="{query: { status: 'unpublished'}}">En revisión</b-nav-item>
      <b-nav-item exact :to="{query: { status: 'rejected'}}">Rechazados</b-nav-item>
    </b-nav>

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
        <b-dropdown size="sm" :text="props.rowData.status" class="m-0">
          <b-dropdown-item v-if="canDataTable(props, 'publish')" @click.prevent="publish(props.rowData)">Publicar</b-dropdown-item>
          <b-dropdown-item v-if="canDataTable(props, 'reject')" @click.prevent="reject(props.rowData)">Rechazar</b-dropdown-item>
          <b-dropdown-item v-if="canDataTable(props, 'finish')" @click.prevent="finish(props.rowData)">Finalizar</b-dropdown-item>
        </b-dropdown>

      </template>
      <template slot="actions" slot-scope="props">
        <div class="btn-group  btn-group-sm" v-if="canDataTable(props, 'update|destroy')">

          <a
            v-if="canDataTable(props, 'update')"
            class="btn btn-primary"
            :href="'/projects/' + props.rowData.id + '/edit?return=admin'">
            <i class="icon-pen"></i> Editar
          </a>

          <router-link v-if="canDataTable(props, 'show')" class="btn btn-primary" :to="{ name: 'projects.edit', params: { id: props.rowData.id } }">
            <i class="icon-eye"></i> Detalles
          </router-link>

          <router-link v-if="canDataTable(props, 'update')" class="btn btn-primary" :to="{ name: 'projects.edit', params: { id: props.rowData.id } }">
            <i class="icon-wrench"></i> Administrar
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
          appends: [
            'can_update',
            'can_destroy',
            'can_show',
            'can_publish',
            'can_reject',
            'can_finish',
            'owner_name',
            'status'
          ],
          status: this.$route.query.status
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
      this.$refs.table.reload()
    }
  },

  methods: {
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
        notify(`Proyecto <strong>${project.name}</strong> finalizado correctamente`)
      })
    }
  }
}
</script>
