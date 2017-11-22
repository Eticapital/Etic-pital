<template>
    <div>
      <div class="card">
        <div class="card-header">
          Crear usuario
        </div>

        <div class="card-block">
          <form @submit.prevent="onSubmit" autocomplete="off">
              <div :class="['form-group', errors.has('name') ? 'has-danger' : (fields.dirty('name') ? 'has-success' : '')]">
                <label class="form-control-label" for="name">Nombre</label>
                <b-form-input
                  data-vv-name="name"
                  v-validate="'required'"
                  v-model="name"
                  type="text"
                  :state="errors.has('name') ? 'danger' : 'success'"
                ></b-form-input>
                <div v-if="errors.has('name')" class="form-control-feedback">
                    {{ errors.first('name') }}
                </div>
              </div>

              <div :class="['form-group', errors.has('email') ? 'has-danger' : (fields.dirty('email') ? 'has-success' : '')]">
                <label class="form-control-label" for="email">Correo electrónico</label>
                <b-form-input
                  data-vv-name="email"
                  v-validate="'required|email'"
                  v-model="email"
                  type="text"
                  :state="errors.has('email') ? 'danger' : 'success'"
                ></b-form-input>
                <div v-if="errors.has('email')" class="form-control-feedback">
                    {{ errors.first('email') }}
                </div>
              </div>

              <div :class="['form-group', errors.has('password') ? 'has-danger' : (fields.dirty('password') ? 'has-success' : '')]">
                <label class="form-control-label" for="password">Contraseña</label>
                <b-form-input
                  data-vv-name="password"
                  v-validate="'required'"
                  v-model="password"
                  type="password"
                  autocomplete="new-password"
                  :state="errors.has('password') ? 'danger' : 'success'"
                ></b-form-input>
                <div v-if="errors.has('password')" class="form-control-feedback">
                    {{ errors.first('password') }}
                </div>
              </div>

            <b-button type="submit" :variant="'primary'" :disabled="errors.any()">Guardar</b-button>
          </form>
        </div><!-- /.card-block -->
      </div><!-- /.card -->
    </div>
</template>

<script>
    export default {
        data: function () {
          return {
            name: '',
            email: '',
          }
        },
        methods: {
          onSubmit() {
            this.$validator.validateAll().then(() => {
                axios.post('')
                console.log('From Submitted!', this.$data);
            }).catch(() => {
                console.log('Correct them errors!');
            });
          }
      }
    }
</script>