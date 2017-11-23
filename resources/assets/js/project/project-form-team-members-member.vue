<template>
  <div>
    <b-form-group>
      <slot name="label" class="d-flex">
        <div class="d-flex">
          Nombre
          <a v-if="index > 0" class="text-danger ml-auto" href="#" @click.prevent="$emit('remove')"><i class="icon-bin"></i> Eliminar</a>
        </div><!-- /.flex -->
      </slot>
      <b-form-input v-model="currentMember.name" />
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
    }
  },

  data () {
    return {
      currentMember: this.member
    }
  },

  watch: {
    currentMember: {
      handler (member) {
        this.$emit('changed', member, this.index)
      },
      deep: true
    }
  }
}
</script>
