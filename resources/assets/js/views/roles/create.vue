<template>
  <b-card>
    <form @submit.prevent="onSubmit" autocomplete="off">
      <form-text :form="form" name="display_name" label="Nombre del grupo" />
      <form-text :form="form" name="description" label="Descripción (opcional)" />
      <button type="submit" :class="['btn btn-primary', form.busy ? 'btn-loading' : '']" :disabled="form.errors.hasErrors()||form.busy">Guardar</button>
    </form>
  </b-card>
</template>

<script>
export default {
  data: function () {
    return {
      role: null,
      form: new Form({
        id: '',
        display_name: '',
        description: ''
      })
    }
  },

  beforeRouteEnter (to, from, next) {
    if (!to.params.id) {
      return next()
    }

    axios.get(App.basePath + 'roles/' + to.params.id)
      .then(function (response) {
        next(vm => {
          vm.role = response.data
          vm.form.appendModel(vm.role)
          bus.breadcrumbParams = { id: vm.role.id }
          bus.breadcrumbAttribs = { display_name: vm.role.display_name }
          bus.$emit('view-ready')
        })
      }).catch(function (error) {
        console.log(error)
        next(false)
      })
  },

  methods: {
    onSubmit () {
      let promise = this.role
        ? App.put(App.basePath + 'roles/' + this.role.id, this.form)
        : App.post(App.basePath + 'roles', this.form)

      promise.then((response) => {
        let next = router.match({name: 'roles.index'}).path
        router.push(next, () => {
          growl(this.role ? 'Grupo actualizado correctamente' : 'Grupo agregado correctamente')
        })
      })
    }
  }
}
</script>
