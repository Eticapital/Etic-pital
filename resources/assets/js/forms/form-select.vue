<template>
  <b-form-group
      :label="label"
      :feedback="form.errors.get(name)"
      :state="form.errors.has(name) ? 'invalid' : ''"
      ref="group"
  >
    <b-form-select
      :state="form.errors.has(name) ? 'invalid' : ''"
      v-model="form[name]"
      ref="input"
      :disabled="form.busy"
      @input="form.errors.clear(name)"
      @change="form.errors.clear(name)"
      :options="optionsWithPlaceholder"
    />
  </b-form-group>
</template>

<script>
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
    options: {
      type: Array,
      required: false
    }
  },

  computed: {
    optionsWithPlaceholder () {
      if (!this.placeholder) {
        return this.options
      }

      return _.merge(this.options, [{
        value: null,
        text: this.placeholder
      }])
    }
  },
}
</script>
