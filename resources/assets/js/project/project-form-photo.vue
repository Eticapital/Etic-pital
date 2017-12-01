<template>
  <div>
    <b-form-group
      label="Imagen principal"
      :feedback="form.errors.get('image')"
      :state="form.errors.has('image') ? 'invalid' : ''"
    >
      <div class="align-items-center justify-content-center justify-content-md-start">
        <div :class="{'PhotoInput': true, 'PhotoInput--active': active }">
          <div class="PhotoInput__wrapper">
            <div @click.prevent="croppa.chooseFile()">
              <img v-if="hasImage" class="PhotoInput__image" :src="uploadedImageUrl" :alt="form.image" >
              <i v-else class="PhotoInput__icon icon-camera" ></i>
            </div>
            <div v-show="active">
              <div class="PhotoInput__toolbar top">
                <b-button-group size="sm" class="mb-1 mx-1">
                  <b-btn variant="secondary-light" @click.prevent="croppa.zoomIn()"><i class="icon-zoom-in"></i></b-btn>
                  <b-btn variant="secondary-light" @click.prevent="croppa.zoomOut()"><i class="icon-zoom-out"></i></b-btn>
                </b-button-group>
                <b-button-group size="sm" class="mb-1 mx-1">
                  <b-btn variant="secondary-light" @click.prevent="croppa.moveLeftwards(10)"><i class="icon-arrow-left"></i></b-btn>
                  <b-btn variant="secondary-light" @click.prevent="croppa.moveRightwards(10)"><i class="icon-arrow-right"></i></b-btn>
                  <b-btn variant="secondary-light" @click.prevent="croppa.moveUpwards(10)"><i class="icon-arrow-up"></i></b-btn>
                  <b-btn variant="secondary-light" @click.prevent="croppa.moveDownwards(10)"><i class="icon-arrow-down"></i></b-btn>
                </b-button-group>
              </div>
              <croppa
                v-model="croppa"
                :width="854"
                :height="480"
                :quality="1"
                :prevent-white-space="true"
                :show-remove-button="!active"
                accept="image/jpeg, image/png"
                placeholder=""
                initial-size="cover"
                :file-size-limit="maxFileSize"
                 @file-type-mismatch="onFileTypeMismatch"
                 @file-size-exceed="onFileSizeExceed"
                 @file-choose="fileChoose"
                 @new-image="newImage"
              />
              <div class="PhotoInput__toolbar bottom">
                <b-button-group class="mt-1 mx-1">
                  <b-btn variant="secondary-light" @click="active = false">Cancelar</b-btn>
                  <b-btn variant="secondary" @click="saveImage">
                    <template v-if="!saving"><i class="icon-floppy-disk"></i> Guardar</template>
                    <wait-dots v-else><i class="icon-spinner spinner"></i> Guardando</wait-dots>
                  </b-btn>
                </b-button-group>
              </div>
            </div>
          </div><!-- /.PhotoInput__wrapper -->
        </div><!-- /.PhotoInput -->

        <div class="mt-3">
          <button
            :class="{
              'btn': true,
              'btn-secondary': !form.errors.has('image'),
              'btn-danger': form.errors.has('image'),
              'disabled': choosing
            }"
            @click.prevent="croppa.chooseFile()">
            <wait-dots v-if="choosing"><i class="spinner icon-spinner"></i></wait-dots>
            <span v-else-if="hasImage">Cambiar imagen</span>
            <span v-else>Sube una imagen</span>
          </button>
        </div>
      </div>
    </b-form-group>

    <div class="PhotoInput__backdrop" v-if="active"></div>
  </div>
</template>

<script>
const axiosFileupload = require('axios-fileupload')

export default {
  props: {
    form: {
      type: Object,
      required: true
    }
  },

  data () {
    return {
      choosing: false,
      saving: false,

      croppa: null,
      maxFileSize: App.maxFileSize ? App.maxFileSize : 2000000,
      active: false,
      uploadedImageUrl: null
    }
  },

  computed: {
    hasImage () {
      return this.form.image
    },
    /**
       * El tamaño en MB
       */
    maxFileSizeInMb () {
      return Math.round(this.maxFileSize * 0.000001)
    }
  },

  methods: {
    saveImage () {
      this.saving = true
      this.croppa.generateBlob((image) => {
        axiosFileupload('/upload/image', image)
          .then(response => {
            console.log(response.data.url)
            this.form.image = response.data.name
            this.uploadedImageUrl = response.data.url
            this.active = false
            this.saving = false
          })
          .catch(errors => {
            this.saving = false
            console.log(errors)
          })
      }, 'image/jpeg', 1)
    },

    /**
       * Cuando se selecciona la imagen
       */
    fileChoose () {
      this.choosing = true
    },

    /**
       * Cuando la imagen se mostró correctamente
       */
    newImage () {
      this.choosing = false
      this.form.errors.clear('image')
      this.active = true
    },

    /**
       * Cuando el tipo de archivo no sea válido
       */
    onFileTypeMismatch () {
      this.form.errors.add('image', 'Tipo de archivo no permitido, solo aceptamos imágenes JPG y PNG')
      this.onError()
    },

    /**
       * Tareas comunes cada vez que ocurre un error
       */
    onError () {
      this.choosing = false
    },

    /**
       * Cuando la imagen selecciona es muy grande
       */
    onFileSizeExceed () {
      this.form.errors.add('image', 'La imagen que seleccionaste es muy grande, el tamaño máximo permitido es ' + this.maxFileSizeInMb + 'MB')
      this.onError()
    }

  }
}
</script>

<style lang="scss">
  @import "resources/assets/sass/globals";

  @import '~vue-croppa/dist/vue-croppa';
  $aspect_ratio: percentage((100/(640/360))/100);
  .PhotoInput {
  display: block;
  width: 100%;
  height: auto;
  position: relative;
  padding: $aspect_ratio 0 0 0;
  }

  .PhotoInput__image {
    display: block;
    width: 100%;
  // max-width: 100%;
  // max-height: 100%;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
    // position: absolute;
    // top: 0;
    // left: 0;
    // bottom: 0;
    // right: 0;
    // border-radius: 100px;
    // width: 100%;
    // height: 100%;
  }

  .PhotoInput__toolbar  {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
    &.top {
      top: -43px;
    }
    &.bottom {
      margin-top: $aspect_ratio + 1
    }

    .btn {
      min-width: inherit;
    }
  }

  .PhotoInput--active {
    z-index: $zindex-modal-backdrop + 1;
  }

  .PhotoInput__backdrop {
    z-index: $zindex-modal-backdrop;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1040;
    background-color: rgba(0, 0, 0, 0.8);
  }

  .PhotoInput__menu {
    z-index: $zindex-modal-backdrop + 2;
  }

  .PhotoInput__icon {
    color: $input-border-color;
    font-size: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: absolute;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
      width: 100%;
      height: 100%;
  }

  .PhotoInput__wrapper {
    display: block;
  max-width: 100%;
  max-height: 100%;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
    // width: 100%;
    // padding-top: 99%;
    // height: 0;
    // position: relative;
    // border-radius: 100px;
    background: #FFF;
    border: $input-border-color 1px solid;
    .croppa-container {
      overflow: hidden;
      // border-radius: 100px;
      position: absolute;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
      width: 100%;
      height: 100%;
      canvas {
        max-width: 100%;
        max-height: 100%;
      }
    }
  }

  .form-group.is-invalid {
    .PhotoInput__wrapper {
      border-color: theme-color('danger')
    }
  }

</style>
