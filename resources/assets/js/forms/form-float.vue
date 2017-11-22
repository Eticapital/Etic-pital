<template>
  <b-form-group
      :label="label"
      :feedback="form.errors.get(name)"
      :state="form.errors.has(name) ? 'invalid' : ''"
      ref="group"
  >
    <input-float
      :state="form.errors.has(name) ? 'invalid' : ''"
      v-model.trim="form[name]"
      ref="input"
      :in-cents="inCents"
      @input="form.errors.clear(name)"
      @change="form.errors.clear(name)"
    ></input-float>
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
      inCents: {
        type: Boolean,
        default: false
      },
      label: {
        type: String,
        required: false
      },
    },
  }
</script>