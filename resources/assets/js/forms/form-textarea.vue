<template>
  <b-form-group
      :feedback="form.errors.get(name)"
      :state="form.errors.has(name) ? 'invalid' : ''"
      ref="group"
  >
    <span v-if="!tooltip" slot="label" v-html="label"></span>
    <span v-else slot="label">
      <span v-html="label"></span>
      <help-icon type="popover" :help="tooltip" />
    </span>
    <b-form-textarea
      :state="form.errors.has(name) ? 'invalid' : ''"
      v-model.trim="form[name]"
      ref="input"
      :rows="rows"
      :placeholder="placeholder"
      :disabled="form.busy"
      @input="form.errors.clear(name)"
      @change="form.errors.clear(name)"
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
    tooltip: {
      type: String,
      required: false
    },
    rows: {
      type: Number,
      required: false,
      default: 3
    }
  }
}
</script>
