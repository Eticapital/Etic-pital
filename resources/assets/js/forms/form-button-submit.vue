<template>
  <b-button
    type="submit"
    :variant="variant"
    :class="{'btn-loading' : form.busy}"
    :disabled="form.errors.hasErrors()||form.busy"
  >
    <slot></slot>
  </b-button>
</template>

<script>
export default {
  props: {
    form: {
      type: Object,
      required: true
    },
    variant: {
      type: String,
      default: 'primary'
    },
  }
}
</script>
