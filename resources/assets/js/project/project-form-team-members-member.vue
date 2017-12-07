<template>
  <div>
    <b-form-group
      :state="form.errors.has(this.name + '.name') ? 'invalid' : ''"
      :feedback="form.errors.get(this.name + '.name')"
    >
      <slot name="label" class="d-flex">
        <div class="d-flex">
          Nombre
          <a v-if="index > 0" class="text-danger ml-auto" href="#" @click.prevent="$emit('remove')"><i class="icon-bin"></i> Eliminar</a>
        </div><!-- /.flex -->
      </slot>
      <b-form-input v-model="currentMember.name" :state="form.errors.has(this.name + '.name') ? 'invalid' : ''" />
    </b-form-group>
    <project-form-links v-model="currentMember.links" label="Redes sociales" />
    <hr>
  </div>
</template>

<script>
import ProjectFormLinks from './project-form-links'

export default {
  components: {
    ProjectFormLinks
  },

  props: {
    index: {
      type: Number,
      required: true
    },
    member: {
      type: Object,
      required: true
    },
    form: Object,
    name: String
  },

  data () {
    return {
      currentMember: this.member
    }
  },

  computed: {
    hasError () {
      if (this.form && this.name && this.form.errors.has(this.name)) {
          return true
      }

      return false
    }
  },

  watch: {
    currentMember: {

      handler (member) {
        this.form.errors.clear(this.name)
        this.$emit('changed', member, this.index)
      },
      deep: true
    }
  }
}
</script>
