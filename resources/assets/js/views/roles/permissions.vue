<template>
    <div class="row">
      <div class="col-md-4 mb-3" v-for="(module, module_name) in modules" >
        <div class="card">
          <div class="card-header" v-text="module"></div><!-- /.card-header -->
        </div><!-- /.col-md-6 -->
        <ul class="list-group list-group-flush">
            <permission
              v-for="(label, name) in permissions[module_name]"
              :key="label + name"
              :module-name="module_name"
              :name="name"
              :label="label"
              :role="role"
              v-model="checkedPermissions"
            ></permission>
        </ul>
      </div><!-- /.col -->
    </div>
</template>

<script>
  import Permission from './_permission.vue';

  export default {
      data: function () {
        return {
          role: {},
          modules: [],
          permissions: [],
          checkedPermissions: [],
        }
      },

      beforeRouteEnter (to, from, next) {
        axios.get(App.basePath + 'roles/' + to.params.id + '/permissions')
          .then((response) => {
            next(vm => {
              vm.role = response.data.role;
              vm.modules = response.data.acl.modules;
              vm.permissions = response.data.acl.permissions;
              vm.checkedPermissions = response.data.rolePermissions;
              bus.breadcrumbParams = { id: vm.role.id };
              bus.breadcrumbAttribs = { display_name: vm.role.display_name };
              bus.$emit('view-ready');
            })
          }).catch((error) => {
            next(false)
          });
      },

      components: {
        Permission
      }
  }
</script>