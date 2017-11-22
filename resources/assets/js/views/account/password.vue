<template>
  <b-card title="Actualizar contraseña">
    <form @submit.prevent="onSubmit" autocomplete="off">
      <form-text :form="form" type="password" name="old_password" label="Tu contraseña actual" />
      <form-text :form="form" type="password" name="password" label="Nueva contraseña" />
      <form-text :form="form" type="password" name="password_confirmation" label="Repite tu nueva contraseña" />
      <button type="submit" :class="['btn btn-primary', form.busy ? 'btn-loading' : '']" :disabled="form.errors.hasErrors()||form.busy">Guardar</button>
  </form>
  </b-card>
</template>

<script>
export default {
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
        let next = router.match({name: 'account.index'}).path
        router.push(next, () => {
          growl('Tu contraseña fue actualizada correctamente.')
        })
      })
    }
  }
}
</script>
