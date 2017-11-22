<template>
  <b-card v-if="user" title="Actualizar mis datos de usuario">
    <form @submit.prevent="onSubmit" autocomplete="off">
      <form-text :form="form" name="name" label="Tu nombre completo" />
      <form-text :form="form" name="email" label="Tu correo electrónico" />
      <button type="submit" :class="['btn btn-primary', form.busy ? 'btn-loading' : '']" :disabled="form.errors.hasErrors()||form.busy">Guardar</button>
    </form>
  </b-card>
</template>

<script>
export default {
  data: function () {
    return {
      user: null,
      form: new Form({
        name: '',
        email: ''
      })
    }
  },

  beforeRouteEnter (to, from, next) {
    axios.get(App.basePath + 'account')
      .then((response) => {
        next(vm => {
          vm.user = response.data
          vm.form.appendModel(vm.user)
          bus.$emit('view-ready')
        })
      }).catch((error) => {
        console.log(error)
        next(false)
      })
  },

  methods: {
    onSubmit () {
      App.put(App.basePath + 'account', this.form).then((user) => {
        let next = router.match({name: 'account.index'}).path
        router.push(next, () => {
          growl('Tu cuenta fue actualizada correctamente')
        })
      })
    }
  }
}
</script>
