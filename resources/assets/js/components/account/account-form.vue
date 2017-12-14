<template>
  <form @submit.prevent="onSubmit" autocomplete="off">
    <form-text :form="form" name="name" label="Tu nombre completo" />
    <form-text :form="form" name="email" label="Tu correo electrónico" />
    <form-text :form="form" name="phone" label="Teléfono" />
    <form-text :form="form" name="organization" label="Organización" />
    <form-text :form="form" name="residence" label="Residencia" />
    <form-button-submit :form="form">Guardar</form-button-submit>
  </form>
</template>

<script>
export default {
  props: {
    windowRedirect: {
      type: Boolean,
      default: false
    },
    user: {
      type: Object,
      required: true
    }
  },

  data: function () {
    return {
      form: new Form({
        name: '',
        email: '',
        phone: '',
        organization: '',
        residence: ''
      })
    }
  },

  created () {
    this.form.appendModel(this.user)
  },

  methods: {
    onSubmit () {
      App.put('/account', this.form).then((user) => {
        if (this.windowRedirect) {
          window.location.replace('/account')
          return
        }

        let next = router.match({name: 'account.index'}).path
        router.push(next, () => {
          growl('Tu cuenta fue actualizada correctamente')
        })
      })
    }
  }
}
</script>
