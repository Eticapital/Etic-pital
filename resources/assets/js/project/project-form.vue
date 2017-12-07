<template>
  <form @submit.prevent="onSubmit" novalidate>
    <div class="container-fluid bg-light">
      <div class="container">
        <div class="content">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <fieldset>
                <p><legend><span class="h2 text-primary">1.</span> <span class="h3">Datos Generales</span></legend></p>
                <form-text :form="form" ref="name" name="name" label="Nombre del proyecto:" />
                <form-text :form="form" ref="holder" name="holder" label="Nombre del titular:" />
                <form-text :form="form" ref="phone" name="phone" label="Teléfono de contacto:" />
                <form-text :form="form" ref="email" name="email" label="Correo de contacto:" />
                <project-form-links
                  ref="holder_links"
                  v-model="form.holder_links"
                  :form="form"
                  name="holder_links"
                  label="Redes sociales del titular"
                />
                <project-form-photo ref="photo" :form="form" name="photo" />
                <form-text :form="form" name="video" placeholder="https://" label="Video de la iniciativa:" />
                <form-map
                  ref="address"
                  :feedback="form.errors.get('address') || form.errors.get('latitude') || form.errors.get('longitude')"
                  :change="form.errors.clear('address') && form.errors.clear('latitude') && form.errors.clear('longitude')"
                  v-model="form.address"
                  :api-key="googleMapsApiKey"
                  :initial-coordinates="{lat: form.latitude, lng: form.longitude}"
                  @location-updated="locationUpdated"
                />
              </fieldset>
            </div> <!-- / .col-lg-8 -->
          </div> <!-- / .row -->
        </div> <!-- / .content -->
      </div> <!-- / .container -->
    </div> <!-- / .container-fluid -->

    <div class="container">
      <div class="content">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <fieldset>
              <p><legend><span class="h2 text-primary">2.</span> <span class="h3">Resumen</span></legend></p>

              <form-textarea
                ref="description"
                :form="form"
                :rich="true"
                name="description"
                label="A qué te dedicas, cuánto tiempo llevas haciéndolo, resultados en ventas, validación de la idea y por qué comenzaste a hacerlo."
              />
            </fieldset>
          </div> <!-- / .col-lg-8 -->
        </div> <!-- / .row -->
      </div> <!-- / .content -->
    </div> <!-- / .container -->

    <div class="container-fluid bg-light">
      <div class="container">
        <div class="content">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <fieldset>
                <p><legend><span class="h2 text-primary">3.</span> <span class="h3">Oportunidad de inversión</span></legend></p>
                <p><strong>Ejemplo 1:</strong> Actualmente en México se está viviendo un crecimiento en la industria, en los últimos 4 años el número de empresas cerveceras pasó de 18 a 40, sin embargo, existe un mercado virgen en el centro y sur del país…</p>
                <p><strong>Ejemplo 2:</strong> Los fundadores han invertido más de 7 millones de pesos de su propio capital durante los 3 años que han trabajado en esto y se han incubado en…)</p>
                <form-textarea
                :form="form"
                name="opportunity"
                :rich="true"
                />
              </fieldset>
            </div> <!-- / .col-lg-8 -->
          </div> <!-- / .row -->
        </div> <!-- / .content -->
      </div> <!-- / .container -->
    </div> <!-- / .container-fluid -->

    <div class="container">
      <div class="content">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <fieldset>
              <p><legend><span class="h2 text-primary">4.</span> <span class="h3">Competencia</span></legend></p>
              <form-textarea
              :form="form"
              name="competition"
              :rich="true"
              />
            </fieldset>
          </div> <!-- / .col-lg-8 -->
        </div> <!-- / .row -->
      </div> <!-- / .content -->
    </div> <!-- / .container -->

    <div class="container-fluid bg-light">
      <div class="container">
        <div class="content">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <fieldset>
                <p><legend><span class="h2 text-primary">5.</span> <span class="h3">Presentación, fotos y videos adicionales de la empresa</span></legend></p>
                <form-files
                  name="key_documents"
                  ref="key_documents"
                  v-model="form.key_documents"
                  :form="form"
                  btn-text="Subir presentación, foto(s) o video(s)"
                />
              </fieldset>
            </div> <!-- / .col-lg-8 -->
          </div> <!-- / .row -->
        </div> <!-- / .content -->
      </div> <!-- / .container -->
    </div> <!-- / .container-fluid -->

    <div class="container">
      <div class="content">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <fieldset>
              <p><legend><span class="h2 text-primary">6.</span> <span class="h3">Página y redes de la empresa</span></legend></p>
              <project-form-links
                ref="links"
                :form="form"
                name="links"
                v-model="form.links"
                label="Tu página oficial, página de facebook, twitter, etc."
              />
            </fieldset>
          </div> <!-- / .col-lg-8 -->
        </div> <!-- / .row -->
      </div> <!-- / .content -->
    </div> <!-- / .container -->

    <div class="container-fluid bg-light">
      <div class="container">
        <div class="content">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <fieldset>
                <p><legend><span class="h2 text-primary">7.</span> <span class="h3">Sectores a lo que pertenece la innovación</span></legend></p>
                <p v-if="sectors === null">
                  <i class="icon-spinner spinner"></i> Cargando sectores...
                </p>
                <b-form-group
                  v-else
                  :feedback="form.errors.get('sectors')"
                  :state="form.errors.has('sectors') ? 'invalid' : ''"
                  ref="sectors"
                >
                  <b-form-checkbox-group @change="form.errors.clear('sectors')" class="form-row" v-model="form.sectors" :state="form.errors.has('sectors') ? 'invalid' : ''" >
                    <div v-for="(chunk, index) in sectorsColumns" class="col" :key="index">
                      <div class="form-check" v-for="sector in chunk" :key="sector.id">
                        <b-form-checkbox :value="sector.id">{{ sector.label }}</b-form-checkbox>
                      </div><!-- /.form-check -->
                    </div>
                  </b-form-checkbox-group>
                </b-form-group>
              </fieldset>
            </div> <!-- / .col-lg-8 -->
          </div> <!-- / .row -->
        </div> <!-- / .content -->
      </div> <!-- / .container -->
    </div> <!-- / .container-fluid -->

    <div class="container">
      <div class="content">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <fieldset>
              <p><legend><span class="h2 text-primary">8.</span> <span class="h3">Etapa de desarrollo de capital</span></legend></p>
              <p v-if="stages === null">
                <i class="icon-spinner spinner"></i> Cargando etapas...
              </p>
              <b-form-group
                v-else
                :feedback="form.errors.get('stage_id')"
                :state="form.errors.has('stage_id') ? 'invalid' : ''"
                ref="stage_id"
              >
                <b-form-radio-group v-model="form.stage_id" stacked :state="form.errors.has('stage_id') ? 'invalid' : ''" @change="form.errors.clear('stage_id')">
                  <b-form-radio v-for="stage in stages" :key="stage.id" :value="stage.id">
                    {{ stage.label }} ({{stage.description}})
                  </b-form-radio>
                </b-form-radio-group>
              </b-form-group>
            </fieldset>
          </div> <!-- / .col-lg-8 -->
        </div> <!-- / .row -->
      </div> <!-- / .content -->
    </div> <!-- / .container -->

    <div class="container-fluid bg-light">
      <div class="container">
        <div class="content">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <fieldset>
                <p><legend><span class="h2 text-primary">9.</span> <span class="h3">Modelo de negocio</span></legend></p>
                <form-textarea
                  :form="form"
                  :rich="true"
                  name="business_model"
                  label="¿Cómo generas dinero? ¿Qué tipo de producto o servicio vendes y quién te lo compra? ¿A través de qué medios lo comercializas o cómo cierras tus ventas?" />
              </fieldset>
            </div> <!-- / .col-lg-8 -->
          </div> <!-- / .row -->
        </div> <!-- / .content -->
      </div> <!-- / .container -->
    </div> <!-- / .container-fluid -->

    <div class="container">
      <div class="content">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <fieldset>
              <p><legend><span class="h2 text-primary">10.</span> <span class="h3">Datos de inversión</span></legend></p>
              <form-money :form="form" :in-cents="true" ref="previous_capital" name="previous_capital" label="Capital previamente obtenido (si aplica)" />
              <form-money :form="form" :in-cents="true" ref="total_sales" name="total_sales" label="Ventas totales al día de hoy (si aplica)" />
              <form-money :form="form" :in-cents="true" ref="round_size" name="round_size" label="Tamaño de la ronda (¿Cuánto necesitas?)" />
              <form-money :form="form" :in-cents="true" ref="minimal_needed" name="minimal_needed" label="¿Cuánto es lo mínimo que te serviría para levantar capital?:" />
            </fieldset>
            <fieldset>
              <div class="form-row">
                <b-form-group
                  label="¿Tienes algún inversionista interesado?"
                  :feedback="form.errors.get('has_interested_investor')"
                  :state="form.errors.has('has_interested_investor') ? 'invalid' : ''"
                  ref="has_interested_investor"
                >
                  <b-form-radio-group
                    v-model="form.has_interested_investor"
                    :state="form.errors.has('has_interested_investor') ? 'invalid' : ''"
                    @change="form.errors.clear('has_interested_investor')"
                  >
                      <b-form-radio :value="true">Sí</b-form-radio>
                      <b-form-radio :value="false">No</b-form-radio>
                  </b-form-radio-group>
                </b-form-group>
              </div> <!-- / .form-row -->
              <form-text
                v-if="form.has_interested_investor"
                :form="form"
                ref="interested_investor_name"
                name="interested_investor_name"
                label="¿Qué inversionista?"
                placeholder="Opcional"
              />
            </fieldset>
            <fieldset>
              <legend class="col-form-legend">Ventas esperadas en los próximos tres años</legend>
              <div class="form-group">
                <div class="form-row">
                  <div class="col-2">
                    <label class="col-form-label">Año 1:</label>
                  </div> <!-- / .col-2 -->
                  <div class="col-6">
                    <form-money :form="form" :in-cents="true" name="expected_sales_year_1" class="mb-0" />
                  </div> <!-- / .col-6 -->
                </div> <!-- / .form-row -->
              </div> <!-- / .form-group -->
              <div class="form-group">
                <div class="form-row">
                  <div class="col-2">
                    <label class="col-form-label">Año 2:</label>
                  </div> <!-- / .col-2 -->
                  <div class="col-6">
                    <form-money :form="form" :in-cents="true" name="expected_sales_year_2" class="mb-0" />
                  </div> <!-- / .col-6 -->
                </div> <!-- / .form-row -->
              </div> <!-- / .form-group -->
              <div class="form-group">
                <div class="form-row">
                  <div class="col-2">
                    <label class="col-form-label">Año 3:</label>
                  </div> <!-- / .col-2 -->
                  <div class="col-6">
                    <form-money :form="form" :in-cents="true" name="expected_sales_year_3" class="mb-0" />
                  </div> <!-- / .col-6 -->
                </div> <!-- / .form-row -->
              </div> <!-- / .form-group -->
            </fieldset>
            <fieldset>
              <legend class="col-form-legend">¿Qué das a cambio de la inversión?</legend>
              <p v-if="rewards === null">
                <i class="icon-spinner spinner"></i> Cargando recompensas...
              </p>
              <b-form-group
                  v-else
                  :feedback="form.errors.get('rewards')"
                  :state="form.errors.has('rewards') ? 'invalid' : ''"
                  ref="rewards"
                >
                  <b-form-checkbox-group
                    class="form-row"
                    v-model="form.rewards"
                    @change="form.errors.clear('rewards')"
                     :state="form.errors.has('rewards') ? 'invalid' : ''"
                  >
                    <div v-for="(chunk, index) in rewardsColumns" class="col" :key="index">
                      <div class="form-check" v-for="reward in chunk" :key="reward.id">
                        <b-form-checkbox :value="reward.id">{{ reward.label }}</b-form-checkbox>
                      </div><!-- /.form-check -->
                    </div>
                  </b-form-checkbox-group>
                </b-form-group>
            </fieldset>
          </div> <!-- / .col-lg-8 -->
        </div> <!-- / .row -->
      </div> <!-- / .content -->
    </div> <!-- / .container -->

    <div class="container-fluid bg-light">
      <div class="container">
        <div class="content">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <fieldset>
                <p><legend><span class="h2 text-primary">11.</span> <span class="h3">Miembros del equipo</span></legend></p>
                <project-form-team-members ref="team" :form="form" name="team" v-model="form.team" />
              </fieldset>
            </div> <!-- / .col-lg-8 -->
          </div> <!-- / .row -->
        </div> <!-- / .content -->
      </div> <!-- / .container -->
    </div> <!-- / .container-fluid -->

    <div class="container">
      <div class="content">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <fieldset>
              <p><legend><span class="h2 text-primary">12.</span> <span class="h3">Indicadores claves de rendimiento (KPIs)</span></legend></p>
              <project-form-kpis v-model="form.kpis" ref="kpis" :form="form" name="kpis" />
            </fieldset>
          </div> <!-- / .col-lg-8 -->
        </div> <!-- / .row -->
      </div> <!-- / .content -->
    </div> <!-- / .container -->

    <div class="container-fluid bg-light">
      <div class="container">
        <div class="content">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <fieldset>
                <p><legend><span class="h2 text-primary">13.</span> <span class="h3">Documentos  Clave</span></legend></p>
                <form-files
                  name="key_documents"
                  ref="key_documents"
                  v-model="form.key_documents"
                  :form="form"
                />
              </fieldset>
            </div> <!-- / .col-lg-8 -->
          </div> <!-- / .row -->
        </div> <!-- / .content -->
      </div> <!-- / .container -->
    </div> <!-- / .container-fluid -->

    <div class="container">
      <div class="content">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <fieldset>
              <p><legend><span class="h2 text-primary">14.</span> <span class="h3">Material extra</span></legend></p>
              <form-files
                name="key_documents"
                ref="key_documents"
                v-model="form.key_documents"
                :form="form"
              />

            </fieldset>
          </div> <!-- / .col-lg-8 -->
        </div> <!-- / .row -->
      </div> <!-- / .content -->
    </div> <!-- / .container -->

    <div class="container-fluid bg-light">
      <div class="container">
        <div class="content">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <p class="text-center">
                <form-button-submit variant="primary" :form="form" @click.prevent.native="submitProject">Enviar solicitud</form-button-submit>
              </p>
            </div> <!-- / .col-lg-8 -->
          </div> <!-- / .row -->
        </div> <!-- / .content -->
      </div> <!-- / .container -->
    </div> <!-- / .container-fluid -->
<b-card v-if="results" title="Resultados del formulario: (Temporal)">
<pre>{{ results }}</pre>
</b-card>

  </form>
</template>

<script>
import ProjectFormLinks from './project-form-links'
import ProjectFormTeamMembers from './project-form-team-members'
import ProjectFormKpis from './project-form-kpis'
import ProjectFormPhoto from './project-form-photo'

export default {
  components: {
    ProjectFormPhoto,
    ProjectFormLinks,
    ProjectFormTeamMembers,
    ProjectFormKpis
  },

  props: {
    googleMapsApiKey: {
      type: String,
      required: true
    }
  },

  data () {
    return {
      form: new Form({
        // 1.
        name: null,
        holder: null,
        phone: null,
        email: null,
        holder_links: null,
        photo: null,
        video: null,
        address: null,
        latitude: 19.4336626,
        longitude: -99.1410542,

        // 2.
        description: '',
        // 3.
        opportunity: '',
        // 4.
        competition: '',
        // 5.
        company_documents: null,
        // 6.
        links: null,
        // 7.
        sectors: null,
        // 8.
        stage_id: null,
        // 9.
        business_model: '',
        // 10.
        previous_capital: null,
        total_sales: null,
        round_size: null,
        minimal_needed: null,
        has_interested_investor: null,
        interested_investor_name: '',
        expected_sales_year_1: null,
        expected_sales_year_2: null,
        expected_sales_year_3: null,
        rewards: null,
        // 11.
        team: null,
        // 12.
        kpis: null,
        // 13.
        key_documents: null,
        // 14.
        extra_documents: null
      }),
      sectors: null,
      stages: null,
      rewards: null,

      // TEMPORAL
      results: null
    }
  },

  computed: {
    sectorsColumns () {
      if (!this.sectors) {
        return []
      }

      return _.chunk(this.sectors, Math.ceil(this.sectors.length / 2))
    },
    rewardsColumns () {
      if (!this.rewards) {
        return []
      }

      return _.chunk(this.rewards, Math.ceil(this.rewards.length / 2))
    }
  },

  created () {
    // Temporar eliminr
    this.loadDemoProject()

    this.loadSectors()
    this.loadStages()
    this.loadRewards()
  },

  methods: {
    loadDemoProject () {
      axios.get('/projects/1')
        .then(response => {
          this.form.appendModel(response.data)
        })
        .catch(errors => {
          console.log("errors", errors)
        })
    },
    onSubmit () {
      //
    },
    submitProject () {
      App.post('/projects', this.form)
        .then(response => {
          this.results = response
        }).catch(errors => {
          if (errors.errors) {
            _.find(errors.errors, (error, name) => {
              name = name.split('.')[0]
              if (name === 'latitude' || name === 'longitude') {
                name = 'address'
              }

              if (!this.$refs[name]) {
                return false
              }

              var input = $('input:visible:not([type=file]), textarea:visible, select:visible, button:visible', this.$refs[name].$el).first()
              if (input.length) {
                $(input).focus()
              } else {
                this.$scrollTo(this.$refs[name].$el, 0)
              }

              if (this.$refs[name].editor) {
                this.$refs[name].editor.focus()
              }

              return true
            })

          }
        })
    },

    locationUpdated (coordinates, isManualChanged) {
      this.form.latitude = coordinates.lat
      this.form.longitude = coordinates.lng
    },

    loadSectors () {
      axios.get('/sectors')
        .then(response => {
          this.sectors = response.data
        })
    },

    loadRewards () {
      axios.get('/rewards')
        .then(response => {
          this.rewards = response.data
        })
    },

    loadStages () {
      axios.get('/stages')
        .then(response => {
          this.stages = response.data
        })
    }
  }
}
</script>
