<template>
  <div :class="{'d-flex': true, 'mt-2': index > 0}">
    <b-form-input
      placeholder="https://"
      @change="addHttps"
      v-model="currentValue"
    />
    <b-button
      v-if="totalLinks == 1"
      @click.prevent="$emit('new-link')"
      size="sm"
      variant="secondary"
      class="ml-2"
    >
      Agregar link
    </b-button>
    <b-button
      v-if="totalLinks > 1"
      @click.prevent="$emit('remove-link')"
      size="sm"
      variant="danger"
      class="ml-2"
    >
      <i class="icon-bin"></i>
    </b-button>
  </div><!-- /.d-flex -->
</template>

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
      currentValue: ''
    }
  },

  watch: {
    currentValue (link) {
      this.$emit('input', this.index, link)
    }
  },

  methods: {
    addHttps () {
      let le = new RegExp('^(http|https)://', 'i')
      if (!le.test(this.currentValue)) {
        this.currentValue = 'http://' + this.currentValue
      }
    }
  }
}
</script>
