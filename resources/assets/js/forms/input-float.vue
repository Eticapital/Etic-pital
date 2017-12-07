<template>
    <b-form-input
      v-model="text"
      :name="name"
      :disabled="disabled"
      :required="required"
      :readonly="readonly || plaintext"
      :placeholder="placeholder"
      :autocomplete="autocomplete || null"
      :state="state"
      @change="isFocus = false"
      @focus.native="isFocus = true"
      @blur.native="isFocus = false"
      @keydown="$emit('keydown')"
    />
</template>

<script>
export default {
  data () {
    return {
      text: null,
      isFocus: false,
      localValue: null
    }
  },

  props: {
    name: {
      type: String
    },
    id: {
      type: String
    },
    disabled: {
      type: Boolean
    },
    required: {
      type: Boolean,
      default: false
    },
    value: {
      default: null
    },
    ariaInvalid: {
      type: [Boolean, String],
      default: false
    },
    readonly: {
      type: Boolean,
      default: false
    },
    plaintext: {
      type: Boolean,
      default: false
    },
    autocomplete: {
      type: String,
      default: null
    },
    placeholder: {
      type: String,
      default: null
    },
    formatter: {
      type: Function
    },
    lazyFormatter: {
      type: Boolean,
      default: false
    },
    inCents: {
      type: Boolean,
      default: false
    },
    state: {
      required: false,
      default: '',
    }
  },

  watch: {
    /**
           * Cuando se cambia el valor real emito un "input"
           */
    realValue (realValue) {
      this.$emit('input', realValue)
    },

    /**
           * Me aseguro de que cada que cambie el texto se actualice el valor local
           */
    text (text) {
      var value = this.toFloat(text)
      this.localValue = value
    },

    /**
           * Me aseguro de que cada que cambie el valor se actualice el texto
           */
    value (value) {
      this.localValue = this.calculateLocalValue(value)
      this.text = this.textInAppropriateFormat
    },

    /**
           * Cunado está enfocado el texto se muestra sin formato para evitar
           * problemas, por ejemplo al copiar y pegar el valor
           */
    isFocus (isFocus) {
      this.text = this.textInAppropriateFormat
    }
  },

  created () {
    this.localValue = this.calculateLocalValue(this.value)
    this.text = this.textInAppropriateFormat
  },

  computed: {
    /**
           * Valor real del input
           * @return intenger
           */
    realValue () {
      var value = this.localValue

      if (value == null) {
        return null
      }

      return this.inCents ? Math.round(value * 100) : value
    },

    /**
           * Valor con formato
           * @return string
           */
    formattedText () {
      return this.formatText(this.localValue)
    },

    /**
           * Valor con formato
           * @return string
           */
    unformattedText () {
      return this.unFormatText(this.localValue)
    },

    /**
           * El texto en el formato adecuado segun el estado del input
           * @return string
           */
    textInAppropriateFormat () {
      return this.isFocus ? this.unformattedText : this.formattedText
    }
  },

  methods: {
    formatMoney (n, c, d, t) {
      var c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? '.' : d,
        t = t == undefined ? ',' : t,
        s = n < 0 ? '-' : '',
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0
      return s + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, '$1' + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : '')
    },
    /**
           * Valor local
           * @return integer
           */
    calculateLocalValue (value) {
      return value == null
        ? null
        : this.toFloat(this.inCents ? Math.round(value / 100) : value)
    },
    /**
           * Convierte cualquier numero en formato valido a un número entero
           * multiplicado por 100 para evitar los decimales
           */
    toFloat (str) {
      if (str !== null && str !== '') {
        var value = parseFloat(String(str).replace(/[^0-9\.]+/g, ''))
        return value
      }

      return null
    },

    /**
           * Da el formato al numero
           */
    formatText (value) {
      let text = value !== null
        ? this.formatMoney(value, 2, '.', ',')
        : ''

      return text && text.endsWith('.00')
        ? text.replace('.00', '')
        : text
    },

    /**
           * Remueve el formato del numero
           */
    unFormatText (value) {
      let text = value !== null
        ? this.formatMoney(value, 2, '.', '')
        : ''

      return text && text.endsWith('.00')
        ? text.replace('.00', '')
        : text
    }
  }
}
</script>
