<template>
  <div v-if="index < totalLinks -1" class="ProjectLink">
    <a :href="currentValue" target="_blank">
      <i :class="'icon-' + icon"></i>
      {{ currentValue }}
    </a>
    <a @click.prevent="$emit('remove-link')" class="ml-auto text-danger" href="#">
      <i class="icon-bin"></i> Eliminar
    </a>
  </div>
  <div v-else :class="{'d-flex': true, 'mt-2': index > 0}" >
    <b-form-input
      placeholder="https://"
      :state="error ? 'invalid' : ''"
      @change="onChange"
      @keyup.enter.native="newLink"
      v-model="currentValue"
    />
    <b-button
      @click.prevent="newLink"
      size="sm"
      :variant="error ? 'danger' : 'secondary'"
      class="ml-2"
    >
      <template v-if="totalLinks > 1">Agregar otro link</template>
      <template v-else>Agregar link</template>
    </b-button>
  </div><!-- /.d-flex -->
</template>

<style lang="scss">
  @import "resources/assets/sass/globals";
  .ProjectLink {
    display: flex;
    align-items: center;
    padding: 10px;
    border-top: 1px solid lighten($input-border-color, 10%);
  }
</style>

<script>
export default {
  props: {
    index: {
      type: Number,
      required: true
    },
    link: {
      type: String,
      required: true
    },
    totalLinks: {
      type: Number,
      required: true
    }
  },

  data () {
    return {
      currentValue: '',
      error: false
    }
  },

  computed: {
    icon () {
      // Vimeo o Youtube
      if (/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/.test(this.currentValue)) {
        return 'youtube'
      }
      if (/(?:https?:\/\/)?(?:www\.)?facebook\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*?(\/)?([^\/?]*)/.test(this.currentValue)) {
        return 'facebook'
      }
      if (/(?:http:\/\/)?(?:www\.)?twitter\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-]*)/.test(this.currentValue)) {
        return 'twitter'
      }
      if (/https?:\/\/(www\.)?instagram\.com\/([A-Za-z0-9_](?:(?:[A-Za-z0-9_]|(?:\.(?!\.))){0,28}(?:[A-Za-z0-9_]))?)/.test(this.currentValue)) {
        return 'instagram'
      }
      if (/((http|https):\/\/|)(www\.|)youtube\.com\/(channel\/|user\/)?[a-zA-Z0-9\-]{1,}/.test(this.currentValue)) {
        return 'youtube'
      }
      if (/https?:\/\/plus\.google\.com\/\+[^/]+|\d{21}/.test(this.currentValue)) {
        return 'google-plus'
      }
      if (/http(s)?:\/\/([\w]+\.)?linkedin\.com\/pub\/[A-z 0-9 _ -]+(\/[A-z 0-9]+){3}\/?/.test(this.currentValue)) {
        return 'linkedin'
      }
      if (/http(s)?:\/\/([\w]+\.)?linkedin\.com\/in\/(A-z 0-9 _ -)\/?/.test(this.currentValue)) {
        return 'linkedin'
      }
      if (/^(http\:\/\/|https\:\/\/)?(www\.)?(vimeo\.com\/)([0-9]+)$/.test(this.currentValue)) {
        return 'vimeo'
      }

      return 'sphere'
    }
  },

  watch: {
    currentValue (link) {
      this.error = false
      this.$emit('input', this.index, link)
    },

    link (link) {
      this.currentValue = link || ''
    }
  },

  created () {
    this.currentValue = this.link || ''
  },

  methods: {
    newLink () {
      if (!this.currentValue || !this.isValidUrl(this.currentValue)) {
        this.error = true
      } else {
        this.$emit('new-link')
      }
    },

    onChange () {
      this.addHttps()
      if (this.isValidUrl(this.currentValue)) {
        this.newLink()
      }
    },

    isValidUrl (url) {
      var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
      '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|' + // domain name
      '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
      '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
      '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
      '(\\#[-a-z\\d_]*)?$', 'i') // fragment locator
      return pattern.test(url)
    },

    addHttps () {
      let le = new RegExp('^(http|https)://', 'i')
      if (!le.test(this.currentValue)) {
        this.currentValue = 'http://' + this.currentValue
      }
    }
  }
}
</script>
