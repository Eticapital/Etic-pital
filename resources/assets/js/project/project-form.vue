<template>
  <form action="">
    <div class="container-fluid bg-light">
      <div class="container">
        <div class="content">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <fieldset>
                <p><legend><span class="h2 text-primary">1.</span> <span class="h3">Datos Generales</span></legend></p>
                <form-text :form="form" name="name" label="Nombre del proyecto:" />
                <form-text :form="form" name="holder" label="Nombre del titular:" />
                <form-text :form="form" name="phone" label="Teléfono de contacto:" />
                <form-text :form="form" name="email" label="Correo de contacto:" />
                <project-form-links v-model="form.links" label="Redes sociales del titular" />
                <form-text :form="form" name="video" placeholder="https://" label="Video de la iniciativa:" />
                <form-map
                  v-model="form.address"
                  :api-key="googleMapsApiKey"
                  :initial-latitude="form.latitude"
                  :initial-longitude="form.longitude"
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

              <form-textarea :form="form" name="description" label="A qué te dedicas, cuánto tiempo llevas haciéndolo, resultados en ventas, validación de la idea y por qué comenzaste a hacerlo." />
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
                <p><legend><span class="h2 text-primary">5.</span> <span class="h3">Presentación y videos adicionales de la empresa</span></legend></p>
                <form-files v-model="form.company_files" />
                <!-- <div class="form-group file-upload">
                  <label><span class="btn btn-secondary file-button">Subir presentación</span></label>
                  <input type="file" class="file-trigger">
                </div> <!-- / .form-group -->
              </fieldset>
            </div> <!-- / .col-lg-8 -->
          </div> <!-- / .row -->
        </div> <!-- / .content -->
      </div> <!-- / .container -->
    </div> <!-- / .container-fluid -->

  </form>
</template>

<script>
import ProjectFormLinks from './project-form-links'

export default {
  components: {
    ProjectFormLinks
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
        name: '',
        holder: '',
        phone: '',
        email: '',
        video: '',
        address: '',
        latitude: 19.4336626,
        longitude: -99.1410542,
        links: [''],
        // 2.
        description: '',
        // 3.
        opportunity: '',
        // 4.
        competition: '',
        // 5.
        company_files: []
      })
    }
  },

  methods: {
    locationUpdated (coordinates, isManualChanged) {
      this.form.latitude = coordinates.lat
      this.form.longitude = coordinates.lng
    }
  }
}
</script>
