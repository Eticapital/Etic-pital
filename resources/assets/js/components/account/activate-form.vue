<template>
  <form @submit.prevent="onSubmit" autocomplete="off">
    <form-text :form="form" type="password" name="password" label="Escribe tu nueva contraseña" />
    <form-text :form="form" type="password" name="password_confirmation" label="Repite tu nueva contraseña" />
    <form-button-submit :form="form">Guardar</form-button-submit>
  </form>
</template>

<script>
export default {
  props: {
    email: {
      type: String,
      required: true,
    },
    token: {
      type: String,
      required: true
    }
  },

  data: function () {
    return {
      form: new Form({
        password: '',
        password_confirmation: ''
      })
    }
  },

  methods: {
    onSubmit () {
      App.put(`/account/${this.email}/activate/${this.token}`, this.form).then((user) => {
        window.location.replace('/account')
      })
    }
  }
}
</script>