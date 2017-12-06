<template>
  <div>
    <p v-if="busy"><i class="icon-spinner spinner"></i> Cargando...</p>
  </div>
</template>

<script>
import { Slider, SliderItem } from 'vue-easy-slider'

export default {
  components: {
    Slider,
    SliderItem
  },

  props: {
    projectId: {
      type: Number,
      required: true
    }
  },

  data () {
    return {
      busy: false
    }
  }
}
</script>
