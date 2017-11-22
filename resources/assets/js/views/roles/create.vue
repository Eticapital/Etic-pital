<template>
    <div class="card">
      <div class="card-block">
        <form @submit.prevent="onSubmit" autocomplete="off">
            <div :class="['form-group', form.errors.has('display_name') ? 'has-danger' : '']">
              <label class="form-control-label" for="form.display_name">Nombre</label>
              <b-form-input
                v-model="form.display_name"
                type="text"
                :state="form.errors.has('display_name') ? 'danger' : 'success'"
                @keydown.native="form.errors.clear('display_name')"
              ></b-form-input>
              <div v-if="form.errors.has('display_name')" class="form-control-feedback">
                  {{ form.errors.get('display_name') }}
              </div>
            </div>

            <div :class="['form-group', form.errors.has('description') ? 'has-danger' : '']">
              <label class="form-control-label" for="description">Descripción</label>
              <b-form-input
                v-model="form.description"
                type="text"
                :state="form.errors.has('description') ? 'danger' : 'success'"
                @keydown.native="form.errors.clear('description')"
              ></b-form-input>
              <div  v-if="form.errors.has('description')" class="form-control-feedback">
                  {{ form.errors.get('description') }}
              </div>
            </div>

            <button type="submit" :class="['btn btn-primary', form.busy ? 'btn-loading' : '']" :disabled="form.errors.hasErrors()||form.busy" v-text="form.busy ? 'Guardando...' : 'Guardar'"></button>
        </form>
      </div><!-- /.card-container -->
    </div>
</template>

<script>
    export default {
        data: function () {
          return {
            role: null,
            form: new Form({
              id: '',
              display_name: '',
              description: '',
            }),
          }
        },

        beforeRouteEnter (to, from, next) {
          if (!to.params.id) {
            return next();
          }

          axios.get(App.basePath + 'roles/' + to.params.id)
            .then(function (response) {
              next(vm => {
                vm.role = response.data;
                vm.form.appendModel(vm.role);
                bus.breadcrumbParams = { id: vm.role.id };
                bus.breadcrumbAttribs = { display_name: vm.role.display_name };
                bus.$emit('view-ready');
              })
            }.bind(this)).catch(function (error) {
              next(false)
            });
        },

        methods: {
            onSubmit() {
                let promise = this.role
                    ? App.put(App.basePath + 'roles/' + this.role.id, this.form)
                    : App.post(App.basePath + 'roles', this.form)

                promise.then((response) => {
                    let next = router.match({name: 'roles.index'}).path;
                    router.push(next);
                });
            },
        },
    }
</script>