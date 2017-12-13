<template>
  <form @submit.prevent="onSubmit" novalidate>
    <div class="container-fluid bg-light py-3">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <fieldset>
              <p><legend><span class="h2 text-primary">1.</span> <span class="h3">Monto a invertir</span></legend></p>
              <form-money :form="form" ref="amount" name="amount" label="Inversión mínima de $5,000.00" :in-cents="true" />
            </fieldset>
          </div> <!-- / .col-lg-8 -->
        </div> <!-- / .row -->
      </div> <!-- / .container -->
    </div> <!-- / .container-fluid -->

    <div class="container-fluid bg-white py-3">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <fieldset>
              <p><legend><span class="h2 text-primary">2.</span> <span class="h3">Tus datos</span></legend></p>
              <form-text :form="form" ref="name" name="name" label="Tu nombre completo:" />
              <form-text :form="form" ref="email" name="email" label="Dirección de correo:" />
              <form-text :form="form" ref="phone" name="phone" label="Teléfono" />
              <form-text :form="form" ref="organization" name="organization" label="Organización (Opcional)" />
              <form-text :form="form" ref="residence" name="residence" label="Lugar de residencia" />

              <p class="text-center">
                <form-button-submit
                  type="button"
                  class="btn-wide"
                  variant="primary"
                  :form="form"
                  @click.prevent.native="submitInvestment"
                >
                  Enviar promesa
                </form-button-submit>
              </p>
            </fieldset>
          </div> <!-- / .col-lg-8 -->
        </div> <!-- / .row -->
      </div> <!-- / .container -->
    </div> <!-- / .container-fluid -->
  </form>
</template>

<script>
export default {
  props: {
    projectId: {
      type: Number,
      required: true
    },
  },
  data () {
    return {
      form: new Form({
        // 1.
        amount: null,
        name: '',
        email: '',
        phone: '',
        organization: '',
        residence: ''
      })
    }
  },

  methods: {
    onSubmit () {
      return
    },

    submitInvestment () {
      let promise = App.post(`/projects/${this.projectId}/invertir`, this.form)

      promise.then(response => {
        window.location.replace(response.redirect_to)
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
