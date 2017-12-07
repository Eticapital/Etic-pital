<template>
  <div>
    <b-form-group
      :state="form.errors.has(this.name + '.time') ? 'invalid' : ''"
      :feedback="form.errors.get(this.name + '.time')"
    >
      <slot name="label" class="d-flex">
        <div class="d-flex">
          Tiempo:
          <a v-if="index > 0" class="text-danger ml-auto" href="#" @click.prevent="$emit('remove')"><i class="icon-bin"></i> Eliminar</a>
        </div><!-- /.flex -->
      </slot>
      <b-form-input v-model="currentKpi.time" placeholder="Dos semanas, un mes, un año" :state="form.errors.has(this.name + '.time') ? 'invalid' : ''"  />
    </b-form-group>
    <b-form-group
      :state="form.errors.has(this.name + '.description') ? 'invalid' : ''"
      :feedback="form.errors.get(this.name + '.description')"
      label="Descripcion:"
    >

      <b-form-textarea rows="4" v-model="currentKpi.description" :state="form.errors.has(this.name + '.description') ? 'invalid' : ''"   />
    </b-form-group>
    <hr>
  </div>
</template>

<script>
export default {
  props: {
    index: {
      type: Number,
      required: true
    },
    kpi: {
      type: Object,
      required: true
    },
    form: Object,
    name: String
  },

  data () {
    return {
      currentKpi: this.kpi
    }
  },

  watch: {
    currentKpi: {
      handler (kpi) {
        this.$emit('changed', kpi, this.index)
      },
      deep: true
    }
  }
}
</script>
