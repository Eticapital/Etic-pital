<template>
  <form @submit.prevent="onSubmit" novalidate>

      <div class="container-fluid bg-light">
        <div class="container">
          <div class="content">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <fieldset>
                <p><legend><span class="h2 text-primary">1.</span> <span class="h3">Tus datos</span></legend></p>
                  <form-text :form="form" ref="name" name="name" label="Nombre:" />
                  <form-text :form="form" ref="email" name="email" type="email" label="Correo de contacto:" />
                  <form-text :form="form" ref="phone" name="phone" label="Teléfono de contacto" />
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
              <p><span class="h2 text-primary">2.</span> <span class="h3">¿Qué tipo de inversionista eres?</span></legend></p>
                <fieldset>
                  <div class="form-row">
                    <legend class="col-form-legend">¿Eres un inversionista acreditado o institucional?</legend>
                    <div class="col">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input v-model="form.acreditado" class="form-check-input" type="radio" name="inversionista-acreeditado" :value="true" >
                          Sí
                        </label>
                      </div> <!-- / .form-check -->
                    </div> <!-- / .col -->
                    <div class="col">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input v-model="form.acreditado" class="form-check-input" type="radio" name="inversionista-acreeditado" :value="false" >
                          No
                        </label>
                      </div> <!-- / .form-check -->
                    </div> <!-- / .col -->
                  </div> <!-- / .form-row -->
                </fieldset> <!-- / .form-group -->
                <fieldset>
                  <div class="form-row">
                    <legend class="col-form-legend">¿Manejas un portafolio superior a los $100,000 pesos?</legend>
                    <div class="col">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input v-model="form.portafolio" class="form-check-input" type="radio" name="inversionista-portafolio" :value="true">
                          Sí
                        </label>
                      </div> <!-- / .form-check -->
                    </div> <!-- / .col -->
                    <div class="col">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input v-model="form.portafolio" class="form-check-input" type="radio" name="inversionista-portafolio" :value="false">
                          No
                        </label>
                      </div> <!-- / .form-check -->
                    </div> <!-- / .col -->
                  </div> <!-- / .form-row -->
                </fieldset> <!-- / .form-group -->
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
                  <p><legend><span class="h2 text-primary">3.</span> <span class="h3">Acerca de tu inversión</span></legend></p>
                  <form-money :form="form" ref="investment" name="investment" label="¿Cuánto deseas invertir?" />
                  <div class="form-group">
                    <p>Elige las categorías de proyecto que más te interesan para invertir:</p>
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

                      <legend class="col-form-legend">¿Cuál es tu nivel de interés para invertir?</legend>
                      <div class="form-rating">
                        <div class="rating-option">
                            <input v-model="form.level" :value="1" type="radio" id="rating-option-1" name="inversionista-level" checked>
                            <label for="rating-option-1">1</label>
                        </div>
                        <div class="rating-option">
                            <input v-model="form.level" :value="2" type="radio" id="rating-option-2" name="inversionista-level">
                            <label for="rating-option-2">2</label>
                        </div> <!-- / .form-rating -->
                        <div class="rating-option">
                            <input v-model="form.level" :value="3" type="radio" id="rating-option-3" name="inversionista-level">
                            <label for="rating-option-3">3</label>
                        </div> <!-- / .form-rating -->
                        <div class="rating-option">
                            <input v-model="form.level" :value="4" type="radio" id="rating-option-4" name="inversionista-level">
                            <label for="rating-option-4">4</label>
                        </div> <!-- / .form-rating -->
                        <div class="rating-option">
                            <input v-model="form.level" :value="5" type="radio" id="rating-option-5" name="inversionista-level">
                            <label for="rating-option-5">5</label>
                        </div> <!-- / .form-rating -->
                      </div>
                      <div class="d-flex justify-content-between">
                        <small class="text-primary">Sólo tengo curiosidad</small>
                        <small class="text-primary">Estoy listo para invertir</small>
                      </div>

                    </div> <!-- / .form-row -->

                  <form-textarea :form="form" ref="comments" name="comments" label="¿Tienes algún comentario extra?" />
              </div> <!-- / .col-lg-8 -->
            </div> <!-- / .row -->
          </div> <!-- / .content -->
        </div> <!-- / .container -->
      </div> <!-- / .container-fluid -->


      <div class="container-fluid">
        <div class="container">
          <div class="content">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <p class="text-center">
                <form-button-submit
                  type="button"
                  class="btn-wide"
                  variant="primary"
                  :form="form"
                  @click.prevent.native="submitForm"
                >
                  Enviar solicitud
                </form-button-submit>
              </p>
              </div> <!-- / .col-lg-8 -->
            </div> <!-- / .row -->
          </div> <!-- / .content -->
        </div> <!-- / .container -->
      </div> <!-- / .container-fluid -->

  </form>
</template>

<script>
export default {
  data () {
    return {
      form: new Form({
        // 1.
        name: '',
        phone: '',
        email: '',
        acreditado: false,
        portafolio: false,
        investment: null,
        level: 1,
        sectors: [],
        comments: ''
      }),
      sectors: null
    }
  },

  computed: {
    sectorsColumns () {
      if (!this.sectors) {
        return []
      }

      return _.chunk(this.sectors, Math.ceil(this.sectors.length / 2))
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

    onSubmit () {
      return false
    },

    submitForm () {
      let promise = App.post(`/fondo-de-inversion`, this.form)

      promise.then(response => {
        if (response.redirect_to) {
          window.location.replace(response.redirect_to)
        }
      }).catch(errors => {
        if (errors.errors) {
          _.find(errors.errors, (error, name) => {
            name = name.split('.')[0]

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
    }
  }
}
</script>
