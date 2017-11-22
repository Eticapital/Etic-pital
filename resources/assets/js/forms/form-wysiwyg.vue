<template>
  <b-form-group
  :feedback="form.errors.get(name)"
  :state="form.errors.has(name) ? 'invalid' : ''"
  :description="description"
  ref="group"
  >
  <span v-if="!tooltip" slot="label" v-html="label"></span>
  <span v-else slot="label">
    <span v-html="label"></span>
    <help-icon type="popover" :help="tooltip" />
  </span>

  <froala
  :tag="'textarea'"
  :config="config"
  v-model="form[name]"
  ref="input"
  @input="form.errors.clear(name)"
  @change="form.errors.clear(name)"
  />
</b-form-group>
</template>

<script>
import { mapState } from 'vuex'

export default {
  props: {
    form: {
      type: Object,
      required: true
    },
    name: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: false
    },
    placeholder: {
      type: String,
      required: false
    },
    tooltip: {
      type: String,
      required: false
    },
    description: {
      type: String,
      required: false
    },
    rows: {
      type: Number,
      required: false,
      default: 3
    }
  },

  computed: {
    ...mapState(['user', 'maxFileSize']),
    config () {
      return {
        language: 'es',
        // @TOO agregar el link del mismo proyecto
        linkList: false,
        linkStyles: false,
        heightMin: this.rows * 30,
        placeholderText: this.placeholder,
        editorClass: 'form-control',
        toolbarInline: true,
        charCounterCount: false,
        toolbarVisibleWithoutSelection: true,
        imageMaxSize: this.maxFileSize,
        htmlAllowedTags: ['p', 'br', 'strong', 'a', 'ul', 'ol', 'li', 'em', 'u', 'img', 'iframe'],
        toolbarButtons: [
          'bold', 'italic', 'underline',
          '|', 'align', 'formatOL', 'formatUL',
          '|', 'insertLink', 'insertImage', 'insertVideo'
        ],

        ...!this.user ? {
          imageUpload: false,
          imagePaste: false,
          imageInsertButtons: ['imageBack', '|', 'imageUpload', 'imageByURL']
        } : {
          // Set a preloader.
          imageManagerPreloader: '/img/loading.svg',

          // Set page size.
          imageManagerPageSize: 20,

          // Set a scroll offset (value in pixels).
          imageManagerScrollOffset: 10,

          // Set the load images request URL.
          imageManagerLoadURL: '/image',

          // Set the load images request type.
          imageManagerLoadMethod: 'GET',

          // Set the delete image request URL.
          imageManagerDeleteURL: '/image',

          // Set the delete image request type.
          imageManagerDeleteMethod: 'DELETE',

          imageUploadURL: '/image/upload',

          // Headers para envio de petición
          requestHeaders: axios.defaults.headers.common
        },

        events: {
          'froalaEditor.initialized': function () {
            // console.log('initialized')
          },
          'froalaEditor.focus': function (e, editor) {
            editor.$box.addClass('is-focus')
          },
          'froalaEditor.blur': function (e, editor) {
            editor.$box.removeClass('is-focus')
          }
        }
      }
    }
  }
}
</script>

  <style lang="scss">
  @import 'resources/assets/sass/_variables';

  .fr-wrapper > div:first-child {
    display: none !important;
  }
  .fr-placeholder {
    padding-top: 0 !important;
    color: $input-placeholder-color !important;
  }

  .fr-toolbar,
  .fr-modal .fr-modal-wrapper .fr-modal-head{
    background: #EEEFF5;
    border-color: theme-color("primary");
  }

  .fr-box.form-control.is-focus {
    background: #FFF;
  }

  .fr-popup,
  .fr-modal .fr-modal-wrapper {
    border-color: theme-color("primary");
  }

  .fr-toolbar .fr-command.fr-btn.fr-active, .fr-popup .fr-command.fr-btn.fr-active {
    color: darken(theme-color("primary"), 15%);
  }
  .fr-toolbar .fr-command.fr-btn, .fr-popup .fr-command.fr-btn {
    color: theme-color("primary");
  }
  .fr-popup .fr-action-buttons button.fr-command:hover, .fr-popup .fr-action-buttons button.fr-command:focus {
    color: theme-color("primary");
  }

  .fr-popup .fr-action-buttons button.fr-command {
   color: theme-color("primary");
 }

 .fr-arrow {
  border-bottom-color: theme-color("primary") !important;
}

</style>
