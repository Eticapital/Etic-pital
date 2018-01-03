<template>
<div>
  <div class="d-flex align-items-center mb-3">
    <span class="mr-3">Filtrar:</span>
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
  <template v-if="!busy">
  <b-card title="Resumen de proyectos">
    <b-card-group deck>
      <b-card bg-variant="success" text-variant="white" no-body>
        <router-link
          :to="{name: 'projects.index', query: {status: 'published'}}"
          class="text-white" slot="header">
          Proyectos publicados
        </router-link>
        <router-link :to="{name: 'projects.index', query: {status: 'published'}}" class="text-white">
          <b-card-body>
            <p class="card-text">No. de proyectos: <strong>{{data.total_published_projects}}</strong></p>
            <p class="card-text">Meta total: <strong>{{ data.goal_published_projects / 100 | currency | placeholder('-') }}</strong></p>
            <p class="card-text">Recaudado: <strong>{{ data.collected_published_projects / 100 | currency | placeholder('-') }}</strong></p>
          </b-card-body>
        </router-link>
      </b-card>
      <b-card
        bg-variant="info"
        text-variant="white"
        no-body
      >
        <router-link
          :to="{name: 'projects.index', query: {status: 'unpublished'}}"
          class="text-white" slot="header">
          Proyectos por revisar
        </router-link>
        <router-link :to="{name: 'projects.index', query: {status: 'unpublished'}}" class="text-white">
          <b-card-body>
            <p class="card-text">No. de proyectos: <strong>{{data.total_pending_projects}}</strong></p>
            <p class="card-text">Meta total: <strong>{{ data.goal_pending_projects / 100 | currency | placeholder('-') }}</strong></p>
          </b-card-body>
        </router-link>
      </b-card>

      <b-card bg-variant="danger" text-variant="white" no-body>
        <router-link
          :to="{name: 'projects.index', query: {status: 'rejected'}}"
          class="text-white" slot="header">
          Proyectos rechazados
        </router-link>
        <router-link :to="{name: 'projects.index', query: {status: 'rejected'}}" class="text-white">
          <b-card-body>
            <p class="card-text">No. de proyectos: {{data.total_rejected_projects}}</p>
            <p class="card-text">Meta total: <strong>{{ data.goal_rejected_projects / 100 | currency | placeholder('-') }}</strong></p>
          </b-card-body>
        </router-link>
      </b-card>
    </b-card-group>
  </b-card>

  <b-card title="Resumen de inversiones" class="mt-3">
    <b-card-group deck>
      <b-card bg-variant="success" text-variant="white" no-body>
        <router-link
          :to="{name: 'investments.index', query: {status: 1}}"
          class="text-white" slot="header">
          Inversiones aceptadas
        </router-link>
        <router-link :to="{name: 'investments.index', query: {status: 1}}" class="text-white">
          <b-card-body>
            <p class="card-text">No. de inversiones: {{data.total_accepted_investments}}</p>
            <p class="card-text">Valor total: <strong>{{ data.value_accepted_investments / 100 | currency | placeholder('-') }}</strong></p>
          </b-card-body>
        </router-link>
      </b-card>
      <b-card
        bg-variant="info"
        text-variant="white"
        no-body
      >
        <router-link
          :to="{name: 'investments.index', query: {status: 0}}"
          class="text-white" slot="header">
          Inversiones por revisar
        </router-link>
        <router-link :to="{name: 'investments.index', query: {status: 0}}" class="text-white">
          <b-card-body>
            <p class="card-text">No. de inversiones: {{data.total_pending_investments}}</p>
            <p class="card-text">Valor total: <strong>{{ data.value_pending_investments / 100 | currency | placeholder('-') }}</strong></p>
          </b-card-body>
        </router-link>
      </b-card>

      <b-card bg-variant="danger" text-variant="white" no-body>
        <router-link
          :to="{name: 'investments.index', query: {status: -1}}"
          class="text-white" slot="header">
          Inversiones rechazadas
        </router-link>
        <router-link :to="{name: 'investments.index', query: {status: -1}}" class="text-white">
          <b-card-body>
            <p class="card-text">No. de inversiones: {{data.total_rejected_investments}}</p>
            <p class="card-text">Valor total: <strong>{{ data.value_rejected_investments / 100 | currency | placeholder('-') }}</strong></p>
          </b-card-body>
        </router-link>
      </b-card>
    </b-card-group>
  </b-card>
  </template>
</div>
</template>

<script>
import Datepicker from 'vuejs-datepicker'

export default {
  components: {
    Datepicker
  },

  data: function () {
    return {
      busy: true,
      data: null,
      from: this.$route.query.from ? moment(this.$route.query.from).toDate() : null,
      to: this.$route.query.to ? moment(this.$route.query.to).toDate() : null
    }
  },

  watch: {
    from (from) {
      this.loadData()
    },
    to (to) {
      this.loadData()
    }
  },

  methods: {
    loadData () {
      this.busy = true
      let params = {
        from: this.from,
        to: this.to
      }
      axios.get(App.basePath + 'dashboard', {params: params}).then((response) => {
        this.busy = false
        this.data = response.data
      })
    }
  },

  beforeRouteEnter (to, from, next) {
    axios.get(App.basePath + 'dashboard').then((response) => {
      next(vm => {
        vm.busy = false
        vm.data = response.data
        bus.$emit('view-ready')
      })
    }).catch((error) => {
      console.log(error)
      next(false)
    })
  }
}
</script>
