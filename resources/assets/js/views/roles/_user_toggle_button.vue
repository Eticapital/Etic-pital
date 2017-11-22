<template>
    <a @click="toggleUser(user)" :class="['float-right', 'btn', 'btn-sm', active ? 'btn-danger' : 'btn-success']" href="javascript:;">
        <span v-if="busy"><i class="icon-spinner spinner"></i> Guardando...</span>
        <span v-else-if="active"><i class="icon-bin"></i> Eliminar del grupo</span>
        <span v-else><i class="icon-plus"></i> Agregar al grupo</span>
    </a>
</template>

<script>
    export default {
        data() {
            return {
                busy: false,
                active: this.user.roles.length > 0,
            }
        },

        methods: {
            toggleUser(user) {
                this.busy = true;
                axios.patch(App.basePath + 'roles/' + this.role.id + '/users/' + this.user.id)
                    .then((response) => {
                        this.busy = false;
                        this.active = response.data.has_role;
                    });
            },
        },

        props: ['user', 'role'],
    }
</script>