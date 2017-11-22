<template>
    <div>
       <div class="row" v-if="user">
        <div class="col-xl-3 col-lg-4">
          <div class="card text-xs-center">
            <div class="card-block">
              <div class="user-avatar">
                <img class="avatar" :src="user.avatar_200_url" alt="" />
              </div>
            </div><!-- /.card-block -->
          </div><!-- /.card -->
        </div><!-- /.col -->
        <div class="col-lg">
          <div class="card card-table">
            <div class="card-header">
              Datos del usuario
            </div>
            <table class="table">
              <tr>
                <td>Status:</td>
                <td><published-toggle-link :user="user"></published-toggle-link></td>
              </tr>
              <tr>
                <td>Nombre:</td>
                <td>{{ user.name }}</td>
              </tr>
              <tr>
                <td>Correo:</td>
                <td><a :href="'mailto:' + user.email">{{ user.email }}</a></td>
              </tr>
              <tr v-if="user.roles">
                <td>Roles de usuario:</td>
                <td>{{user.roles}}</td>
              </tr>
              <tr>
                <td>Creado:</td>
                <td>{{ user.created_at | moment('LLL') }}</td>
              </tr>
              <tr>
                <td>Actualizado:</td>
                <td>{{ user.updated_at | moment('LLL') }}</td>
              </tr>
            </table><!-- /.table -->
          </div>
        </div>
      </div><!-- /.row -->
    </div>
</template>

<script>
    import PublishedToggleLink from './_published_toggle_link'

    export default {
        data: function () {
            return {
                user: null
            }
        },

        beforeRouteEnter (to, from, next) {
            axios.get(App.basePath + 'users/' + to.params.id, {
                params: {
                    appends: 'roles'
                }
            }).then((response) =>{
                next(vm => {
                    vm.user = response.data;
                    bus.breadcrumbParams = { id: vm.user.id };
                    bus.breadcrumbAttribs = { name: vm.user.name };
                    bus.$emit('view-ready');
                })
            }).catch((error)  =>{
                next(false)
            });
        },

        components: {
            PublishedToggleLink
        },
    }
</script>