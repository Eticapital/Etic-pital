<template>
  <b-card title="Crear usuario">
    <form @submit.prevent="onSubmit" autocomplete="off">
      <form-money :form="form" ref="amount" name="amount" label="Monto" :in-cents="true" />
      <form-select
        v-if="projects"
        :form="form"
        :options="projectsOptions"
        name="project_id"
        label="Proyecto"
        placeholder="- Selecciona un proyecto -"
      />
      <p v-else><i class="icon-spinner spinner"></i> Cargando proyectos...</p>
      <form-select
        v-if="users"
        :form="form"
        :options="usersOptions"
        name="owner_id"
        label="Usuario"
        placeholder="- Selecciona un usuario -"
      />
      <p v-else><i class="icon-spinner spinner"></i> Cargando usuarios...</p>
      <form-text :form="form" name="name" label="Nombre completo" />
      <form-text :form="form" name="email" label="Correo electrónico" />
      <form-text :form="form" name="phone" label="Teléfono" />
      <form-text :form="form" name="organization" label="Organización" />
      <form-text :form="form" name="residence" label="Lugar de residencia" />

      <form-button-submit :form="form">Guardar</form-button-submit>
    </form>
  </b-card>
</template>

<script>
export default {
  data: function () {
    return {
      investment: null,
      form: new Form({
        id: null,
        project_id: null,
        owner_id: null,
        amount: null,
        name: '',
        email: '',
        phone: '',
        residence: '',
        organization: null,
        investment_status: 0
      }),
      projects: null,
      users: null
    }
  },

  watch: {
    'form.owner_id' (ownerId) {
      let user = this.users.find(user => user.id === ownerId)
      this.form.name = user.name
      this.form.email = user.email
      this.form.phone = user.phone
      this.form.residence = user.residence
      this.form.organization = user.organization
      this.form.organization = user.organization
    }
  },

  computed: {
    projectsOptions () {
      if (!this.projects) {
        return []
      }

      return this.projects.map(project => {
        return {
          value: project.id,
          text: project.name
        }
      })
    },
    usersOptions () {
      if (!this.users) {
        return []
      }

      return this.users.map(user => {
        return {
          value: user.id,
          text: user.name + ' &lt;' + user.email + '&gt;'
        }
      })
    }
  },

  beforeRouteEnter (to, from, next) {
    if (!to.params.id) {
      return next()
    }

    axios.get(App.basePath + 'investments/' + to.params.id)
      .then((response) => {
        next(vm => {
          vm.investment = response.data
          vm.form.appendModel(vm.investment)
          bus.breadcrumbParams = { id: vm.investment.id }
          bus.breadcrumbAttribs = { name: vm.investment.name }
          bus.$emit('view-ready')
        })
      }).catch((error) => {
        next(false)
      })
  },

  created () {
    this.loadProjects()
    this.loadUsers()
  },

  methods: {
    loadProjects () {
      let params = {
        sort: 'name|asc',
        per_page: 9999999
      }

      axios.get(App.basePath + 'projects', { params: params })
        .then(response => {
          this.projects = response.data.data
        })
    },

    loadUsers () {
      let params = {
        sort: 'name|asc',
        per_page: 9999999
      }

      axios.get(App.basePath + 'users', { params: params })
        .then(response => {
          this.users = response.data.data
        })
    },

    onSubmit () {
      let promise = this.user
        ? App.put(App.basePath + 'investments/' + this.investment.id, this.form)
        : App.post(App.basePath + 'investments', this.form)

      promise.then((investment) => {
        let next = router.match({name: 'investments.index'}).path
        router.push(next, () => {
          growl(this.user ? 'Inversión actualizada correctamente' : 'Inversión creada correctamente')
        })
      })
    }
  }
}
</script>
