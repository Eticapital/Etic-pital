<template>
  <div>
    <kpi
      v-for="(kpi, index) in kpis"
      :key="kpi.id"
      :kpi="kpi"
      :index="index"
      @changed="kpiChanged"
      @remove="removeKpi(index)"
    />
    <p><b-btn variant="secondary" @click.prevent="addKpi">Agregar otro KPI</b-btn></p>
  </div>
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
    }
  },

  data () {
    return {
      kpis: []
    }
  },

  watch: {
    kpis: {
      handler (kpis) {
        this.$emit('input', kpis)
      },
      deep: true
    }
  },

  created () {
    this.kpis = this.value ? this.value : [{ id: uniqid(), time: '', description: '' }]
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
