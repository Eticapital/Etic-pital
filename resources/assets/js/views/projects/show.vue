<template>
<div v-if="project">
  <div class="row">
    <div class="col-md-6">
      <b-card
        title="Datos básicos del proyecto"
        class="card-table"
        :img-src="project.photo_380_url"
      >
        <table class="table">
          <tr>
            <td>Nombre del proyecto:</td>
            <td>{{ project.name }}</td>
          </tr>
          <tr v-if="project.video">
            <td>Video:</td>
            <td><a :href="project.video" target="_blank" v-text="project.video"></a></td>
          </tr>
          <tr>
            <td>Nombre del titular:</td>
            <td>{{ project.name }}</td>
          </tr>
          <tr>
            <td>Teléfono de contacto:</td>
            <td v-html="project.phone"></td>
          </tr>
          <tr>
            <td>Correo de contacto::</td>
            <td v-html="project.email_link"></td>
          </tr>
          <tr v-if="project.holder_links.length">
            <td>Redes sociales del titular:</td>
            <td>
              <ul class="list-unstyled">
                <li
                  v-for="(link, index) in project.holder_links"
                  :key="index"
                >
                  <a :href="link" target="_blank" v-text="link"></a>
                </li>
              </ul>
            </td>
          </tr>
          <tr v-if="project.sectors_list.length">
            <td>Sectores a lo que pertenece la innovación:</td>
            <td>
              <ul>
                <li
                  v-for="(sector, index) in project.sectors_list"
                  :key="index"
                  v-text="sector"
                >
                </li>
              </ul>
            </td>
          </tr>
          <tr>
            <td>Etapa del negocio:</td>
            <td>
              {{ project.stage_label }}
              <br ><small v-text="project.stage_description"></small>
            </td>
          </tr>
          <tr v-if="project.address">
            <td>Direccion:</td>
            <td>
              <p>{{ project.address }}</p>
              <div v-if="project.map" v-html="project.map"></div>
            </td>
          </tr>
        </table><!-- /.table -->
      </b-card>
    </div><!-- /.col-md-6 -->
    <div class="col-md-6">
      <b-card class="mb-3 card-table" title="Resumen inversiones">
        <table class="table">
          <tr>
            <td>Recaudado</td>
            <td>{{ project.collected / 100 | currency | placeholder('-') }}</td>
          </tr>
          <tr>
            <td>Meta</td>
            <td>{{ project.goal / 100 | currency | placeholder('-') }}</td>
          </tr>
          <tr>
            <td>Avance</td>
            <td>{{ project.progress | currency('', 0) | placeholder('-') }}%</td>
          </tr>
        </table>
      </b-card>

      <b-card class="mb-3" title="Resumen">
        <div class="small" v-html="project.description"></div>
      </b-card>
      <b-card class="mb-3" title="Oportunidad de inversión">
        <div class="small" v-html="project.opportunity"></div>
      </b-card>
      <b-card class="mb-3" title="Competencia">
        <div class="small" v-html="project.competition"></div>
      </b-card>
      <b-card class="mb-3" title="Modelo de Negocio">
        <div class="small" v-html="project.business_model"></div>
      </b-card>

      <b-card class="mb-3 card-table" title="Datos de la inversión">
        <table class="table">
          <tr>
            <td>Capital previamente obtenido</td>
            <td>{{ project.previous_capital / 100 | currency | placeholder('-') }}</td>
          </tr>
          <tr>
            <td>Ventas totales al día de hoy</td>
            <td>{{ project.total_sales / 100 | currency | placeholder('-') }}</td>
          </tr>
          <tr>
            <td>Tamaño de la ronda</td>
            <td>{{ project.round_size / 100 | currency | placeholder('-') }}</td>
          </tr>
          <tr>
            <td>Mínimo para levantar capital</td>
            <td>{{ project.minimal_needed / 100 | currency | placeholder('-') }}</td>
          </tr>
          <tr>
            <td>Inversionista interesando</td>
            <td>
              <span v-if="project.has_interested_investor">
                Si
                <span v-if="project.interested_investor_name">: {{project.interested_investor_name}}</span>
              </span>
              <span v-else>No</span>
            </td>
          </tr>
          <tr>
            <td>Ventas esperadas</td>
            <td>
              <ul class="list-unstyled m-0">
                <li>Año 1: {{ project.expected_sales_year_1 / 100 | currency | placeholder('-') }}</li>
                <li>Año 2: {{ project.expected_sales_year_2 / 100 | currency | placeholder('-') }}</li>
                <li>Año 3: {{ project.expected_sales_year_3 / 100 | currency | placeholder('-') }}</li>
              </ul><!-- /.list-unstyled -->
            </td>
          </tr>
          <tr>
            <td>Da a cambio de la inversión</td>
            <td>
              <ul v-if="project.rewards_list.length" class="list-unstyled m-0">
                <li
                  v-for="(reward, index) in project.rewards_list"
                  :key="index"
                  v-text="reward"
                ></li>
              </ul><!-- /.list-unstyled -->
            </td>
          </tr>
        </table>
      </b-card>
    </div><!-- /.col-md-6 -->
  </div><!-- /.row -->

  <div class="row mt-3">
    <div class="col-md-6">
      <b-card no-body>
        <b-card-body>
          <h4 class="card-title m-0">Miembros del equipo</h4>
        </b-card-body>
        <b-list-group flush v-if="project.team.length">
          <b-list-group-item
            v-for="member in project.team"
            :key="member.id"
          >
            {{ member.name }}
            <ul class="small list-unstyled" v-if="member.links.length">
              <li v-for="(link, index) in member.links" :key="index">
                <a target="_blank" :href="link" v-text="link"></a>
              </li>
            </ul>
          </b-list-group-item>
        </b-list-group>
      </b-card>
    </div><!-- /.col-md-6 -->
    <div class="col-md-6">
      <b-card no-body>
        <b-card-body>
          <h4 class="card-title m-0">KPIs</h4>
        </b-card-body>
        <b-list-group flush v-if="project.kpis.length">
          <b-list-group-item
            v-for="kpi in project.kpis"
            :key="kpi.id"
          >
            <strong>{{ kpi.time }}</strong>
            <p>{{ kpi.description }}</p>
          </b-list-group-item>
        </b-list-group>
      </b-card>
    </div><!-- /.col-md-6 -->
  </div><!-- /.row -->

  <b-card no-body class="mt-3">
    <b-card-body>
      <h4 class="card-title m-0">Presentación, fotos y videos adicionales de la empresa</h4>
    </b-card-body>
    <b-list-group flush v-if="project.company_documents.length">
      <b-list-group-item
        v-for="document in project.company_documents"
        :key="document.id"
        class="d-flex"
      >
        <project-file :file="document" />
      </b-list-group-item>
    </b-list-group>
  </b-card>

  <b-card no-body class="mt-3">
    <b-card-body>
      <h4 class="card-title m-0">Documentos clave</h4>
    </b-card-body>
    <b-list-group flush v-if="project.key_documents.length">
      <b-list-group-item
        v-for="document in project.key_documents"
        :key="document.id"
        class="d-flex"
      >
        <project-file :file="document" />
      </b-list-group-item>
    </b-list-group>
  </b-card>

  <b-card no-body class="mt-3">
    <b-card-body>
      <h4 class="card-title m-0">Material extra</h4>
    </b-card-body>
    <b-list-group flush v-if="project.extra_documents.length">
      <b-list-group-item
        v-for="document in project.extra_documents"
        :key="document.id"
        class="d-flex"
      >
        <project-file :file="document" />
      </b-list-group-item>
    </b-list-group>
  </b-card>

  <b-card title="Inversiones" class="mt-3">
  <investments-table :project="project" :per-page="5" />
  </b-card>

  <p class="text-center small mt-3">Creado: {{ project.created_at | moment('l LT') }} | Actualizado: {{ project.updated_at | moment('l LT') }}</p>
</div>
</template>

<script>
import ProjectFile from './_projects_file.vue'
import InvestmentsTable from '../investments/investments-table'

export default {
  components: {
    ProjectFile,
    InvestmentsTable
  },
  data: function () {
    return {
      project: null
    }
  },

  beforeRouteEnter (to, from, next) {
    let params = {
      appends: [
        'email_link',
        'photo_380_url',
        'map',
        'sectors_list',
        'stage_label',
        'stage_description',
        'rewards_list',
        'team',
        'kpis',
        'key_documents',
        'company_documents',
        'extra_documents',
        'goal',
        'collected',
        'progress'
      ]
    }
    axios.get(App.basePath + 'projects/' + to.params.id, {params: params}).then((response) => {
      next(vm => {
        vm.project = response.data
        bus.breadcrumbParams = { id: vm.project.id }
        bus.breadcrumbAttribs = { name: vm.project.name }
        bus.$emit('view-ready')
      })
    }).catch((error) => {
      console.log(error)
      next(false)
    })
  }
}
</script>
