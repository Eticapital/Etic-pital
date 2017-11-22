<template>
  <b-form-group
      :feedback="form.errors.get(name)"
      :state="form.errors.has(name) ? 'invalid' : ''"
      ref="group"
  >
    <b-form-checkbox
      :state="form.errors.has(name) ? 'invalid' : ''"
      v-model="form[name]"
      ref="input"
      :id="id"
      :disabled="form.busy"
      @input="form.errors.clear(name)"
      @change="form.errors.clear(name)"
    ><slot></slot></b-form-checkbox>
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
    id: {
      type: String,
      required: false
    }
  }
}
</script>
