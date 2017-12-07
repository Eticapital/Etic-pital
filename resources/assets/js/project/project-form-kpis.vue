<template>
  <b-form-group
      :feedback="form ? form.errors.get(name) : ''"
      :state="form && form.errors.has(name) ? 'invalid' : ''"
      ref="input"
    >
    <kpi
      v-for="(kpi, index) in kpis"
      :key="kpi.id"
      :kpi="kpi"
      :index="index"
      :form="form"
      :name="name + '.' + index"
      @changed="kpiChanged"
      @remove="removeKpi(index)"
    />
    <p><b-btn variant="secondary" @click.prevent="addKpi">Agregar otro KPI</b-btn></p>
  </b-form-group>
</template>

<script>
import Kpi from './project-form-kpis-kpi'

export default {
  components: {
    Kpi
  },

  props: {
    value: {
      type: Array
    },
    form: Object,
    name: String
  },

  data () {
    return {
      kpis: []
    }
  },

  watch: {
    kpis: {
      handler (kpis) {
        this.form.errors.clear(this.name)
        this.$emit('input', kpis)
      },
      deep: true
    },

    value (value) {
      this.kpis = value || [{ id: uniqid(), time: '', description: '' }]
    }
  },

  created () {
    this.kpis = this.value || [{ id: uniqid(), time: '', description: '' }]
  },

  methods: {
    kpiChanged (kpi, index) {
      Vue.set(this.kpis, index, kpi)
    },
    removeKpi (index) {
      this.kpis.splice(index, 1)
    },
    addKpi (kpi, index) {
      this.kpis.push({ id: uniqid(), time: '', description: '' })
    }
  }
}
</script>
