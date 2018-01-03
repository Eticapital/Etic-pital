<template>
  <b-card title="Crear usuario">
    <form @submit.prevent="onSubmit" autocomplete="off">
      <form-text :form="form" name="name" label="Nombre completo" />
      <form-text :form="form" name="email" label="Correo electrónico" />
      <form-text :form="form" name="phone" label="Teléfono" />
      <form-text :form="form" name="organization" label="Organización" />
      <form-text :form="form" name="residence" label="Residencia" />
      <form-text :form="form" type="password" name="password" label="Contraseña" />
      <form-text :form="form" type="password" name="password_confirmation" label="Repite Contraseña" />
      <form-checkbox :form="form" name="is_published">Marcar para activar</form-checkbox>

      <p v-if="roles === null"><i class="spinner icon-spinner"></i> Cargando grupos...</p>
      <b-form-group v-else label="Grupos">
        <b-form-checkbox-group
          stacked
          v-model="form.roles"
          name="roles"
          :options="rolesOptions"
        />
      </b-form-group>

      <form-button-submit :form="form">Guardar</form-button-submit>

    </form>
  </b-card>
</template>

<script>
export default {
  data: function () {
    return {
      user: null,
      roles: null,
      form: new Form({
        id: null,
        name: '',
        email: '',
        password: '',
        phone: '',
        organization: '',
        residence: '',
        password_confirmation: '',
        is_published: false,
        roles: []
      })
    }
  },

  beforeRouteEnter (to, from, next) {
    if (!to.params.id) {
      return next()
    }
    let params = {
      appends: ['roles_ids']
    }
    axios.get(App.basePath + 'users/' + to.params.id, { params:params })
      .then((response) => {
        next(vm => {
          vm.user = response.data
          vm.form.appendModel(vm.user)
          vm.form.roles = vm.user.roles_ids
          bus.breadcrumbParams = { id: vm.user.id }
          bus.breadcrumbAttribs = { name: vm.user.name }
          bus.$emit('view-ready')
        })
      }).catch((error) => {
        next(false)
      })
  },

  computed: {
    rolesOptions () {
      return this.roles.map(role => {
        return {
          value: role.id,
          text: role.display_name
        }
      })
    }
  },

  created () {
    this.loadRoles()
  },

  methods: {
    loadRoles () {
      let params = {
        per_page: 1000000
      }
      axios.get(App.basePath + 'roles', {params: params})
        .then(response => {
          this.roles = response.data.data;
        })
    },
    onSubmit () {
      let promise = this.user
        ? App.put(App.basePath + 'users/' + this.user.id, this.form)
        : App.post(App.basePath + 'users', this.form)

      promise.then((user) => {
        let next = router.match({name: 'users.show', params: {id: user.id}}).path
        router.push(next, () => {
          growl(this.user ? 'Usuario actualizado correctamente' : 'Usuario creado correctamente')
        })
      })
    }
  }
}
</script>
