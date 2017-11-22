<template>
    <div>
      <div class="row">
        <div class="col-xl-3 col-lg-4">
          <div class="card text-xs-center">
            <div class="card-block">
                <user-avatar
                    :current-avatar="currentAvatar"
                    @avatar-changed="avatarChanged"
                ></user-avatar>
            </div><!-- /card-block -->
          </div>
        </div><!-- /.col-4 -->
        <div class="col-lg">
          <div class="card">
            <div class="card-header">
                Datos del usuario
            </div>

            <div class="card-block">
              <form @submit.prevent="onSubmit" autocomplete="off">
                  <input type="hidden" v-model="form.avatar" name="avatar" />

                  <div :class="['form-group', form.errors.has('name') ? 'has-danger' : '']">
                    <label class="form-control-label" for="form.name">Nombre</label>
                    <b-form-input
                      v-model="form.name"
                      type="text"
                      :state="form.errors.has('name') ? 'danger' : 'success'"
                      @keydown.native="form.errors.clear('name')"
                    ></b-form-input>
                    <div v-if="form.errors.has('name')" class="form-control-feedback">
                        {{ form.errors.get('name') }}
                    </div>
                  </div>

                  <div :class="['form-group', form.errors.has('email') ? 'has-danger' : '']">
                    <label class="form-control-label" for="email">Correo electrónico</label>
                    <b-form-input
                      v-model="form.email"
                      type="text"
                      :state="form.errors.has('email') ? 'danger' : 'success'"
                      @keydown.native="form.errors.clear('email')"
                    ></b-form-input>
                    <div  v-if="form.errors.has('email')" class="form-control-feedback">
                        {{ form.errors.get('email') }}
                    </div>
                  </div>

                  <div :class="['form-group', form.errors.has('password') ? 'has-danger' : '']">
                    <label class="form-control-label" for="form.password">Contraseña</label>
                    <b-form-input
                      v-model="form.password"
                      type="password"
                      autocomplete="new-password"
                      :state="form.errors.has('password') ? 'danger' : 'success'"
                      @keydown.native="form.errors.clear('password')"
                    ></b-form-input>
                    <div v-if="form.errors.has('password')" class="form-control-feedback">
                        {{ form.errors.get('password') }}
                    </div>
                  </div>

                  <div :class="['form-group', form.errors.has('is_published') ? 'has-danger' : '']">
                    <label class="custom-control custom-checkbox">
                      <input type="checkbox" v-model="form.is_published" class="custom-control-input">
                      <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">
                            <span v-if="form.is_published">Usuario activado</span>
                            <span v-else>Marcar para activar</span>
                        </span>
                    </label>
                    <div v-if="form.errors.has('is_published')" class="form-control-feedback">
                        {{ form.errors.get('is_published') }}
                    </div>
                  </div>

                  <button type="submit" :class="['btn btn-primary', form.busy ? 'btn-loading' : '']" :disabled="form.errors.hasErrors()||form.busy">Guardar</button>
              </form>
            </div><!-- /.card-block -->
          </div><!-- /.card -->
        </div>
      </div><!-- /.row -->
    </div>
</template>

<script>
    import UserAvatar  from './_avatar.vue';

    export default {
        data: function () {
            return {
                user: null,
                currentAvatar: null,
                form: new Form({
                    id: null,
                    name: '',
                    email: '',
                    password: '',
                    avatar: null,
                    is_published: null,
                }),
            }
        },

        beforeRouteEnter (to, from, next) {
            if (!to.params.id) {
                return next();
            }

            axios.get(App.basePath + 'users/' + to.params.id)
                .then((response) => {
                    next(vm => {
                        vm.user = response.data;
                        vm.currentAvatar = response.data.avatar_200_url;
                        vm.form.appendModel(vm.user);
                        vm.form.avatar = null; // Se maneja independiente

                        bus.breadcrumbParams = { id: vm.user.id };
                        bus.breadcrumbAttribs = { name: vm.user.name };
                        bus.$emit('view-ready');
                    })
                }).catch((error) => {
                    next(false)
                });
        },

        methods: {
            onSubmit() {
                let promise = this.user
                    ? App.put(App.basePath + 'users/' + this.user.id, this.form)
                    : App.post(App.basePath + 'users', this.form)

                promise.then((user) => {
                    let next = router.match({name: 'users.show', params: {id: user.id}}).path;
                    router.push(next);
                });
            },

            avatarChanged(avatar) {
                this.form.avatar = avatar;
            },
        },

        components: {
            UserAvatar
        }
    }
</script>
