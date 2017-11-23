<template>
  <b-form-group
      :label="label"
      :feedback="form.errors.get(name)"
      :state="form.errors.has(name) ? 'invalid' : ''"
      ref="group"
  >
    <b-input-group v-if="isFormGroup" :left="left" :right="right">
      <b-form-input
        :state="form.errors.has(name) ? 'invalid' : ''"
        v-model="form[name]"
        :type="type"
        ref="input"
        :disabled="form.busy"
        :placeholder="placeholder"
        @input="form.errors.clear(name)"
        @change="form.errors.clear(name)"
      />
    </b-input-group>
    <b-form-input
      v-else
      :state="form.errors.has(name) ? 'invalid' : ''"
      v-model="form[name]"
      :type="type"
      ref="input"
      :disabled="form.busy"
      :placeholder="placeholder"
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
    type: {
      type: String,
      default: 'text',
      required: false
    },
    label: {
      type: String,
      required: false
    },
    placeholder: {
      type: String,
      required: false
    },
    left: {
      type: String,
      required: false
    },
    right: {
      type: String,
      required: false
    }
  },

  computed: {
    isFormGroup () {
      return this.right || this.left
    }
  }
}
</script>
