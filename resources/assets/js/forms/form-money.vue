<template>
  <b-form-group
      :label="label"
      :feedback="form.errors.get(name)"
      :state="form.errors.has(name) ? 'invalid' : ''"
      ref="group"
  >
    <b-input-group left="$" :state="form.errors.has(name) ? 'invalid' : ''">
      <input-float
        :state="form.errors.has(name) ? 'invalid' : ''"
        v-model.trim="form[name]"
        :in-cents="inCents"
        ref="input"
        @input="form.errors.clear(name)"
        @change="form.errors.clear(name)"
      />
    </b-input-group>
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
    }
  }
}
</script>
