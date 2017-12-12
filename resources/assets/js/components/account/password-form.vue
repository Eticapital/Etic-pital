<template>
  <form @submit.prevent="onSubmit" autocomplete="off">
    <form-text :form="form" type="password" name="old_password" label="Tu contraseña actual" />
    <form-text :form="form" type="password" name="password" label="Nueva contraseña" />
    <form-text :form="form" type="password" name="password_confirmation" label="Repite tu nueva contraseña" />
    <form-button-submit :form="form">Guardar</form-button-submit>
  </form>
</template>

<script>
export default {
  props: {
    windowRedirect: {
      type: Boolean,
      default: false
    }
  },

  data: function () {
    return {
      form: new Form({
        old_password: '',
        password: '',
        password_confirmation: ''
      })
    }
  },

  methods: {
    onSubmit () {
      App.put('/account/password', this.form).then((user) => {
        if (this.windowRedirect) {
          window.location.replace('/account')
          return
        }

        let next = router.match({name: 'account.index'}).path
        router.push(next, () => {
          growl('Tu contraseña fue actualizada correctamente.')
        })
      })
    }
  }
}
</script>