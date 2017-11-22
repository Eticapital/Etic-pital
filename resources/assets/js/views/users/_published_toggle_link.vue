<template>
    <a href="" @click.prevent="togglePublished" :class="published ? 'text-success' : 'text-danger'">
        <span v-if="busy"><i class="icon-spinner spinner"></i> Guardando...</span>
        <span v-else-if="published"><i class="icon-checkmark"></i> Activo</span>
        <span v-else><i class="icon-blocked"></i> Inactivo</span>
    </a>
</template>
<script>
    export default {
        data() {
            return {
                busy: false,
                published: this.user.is_published,
            };
        },

        methods: {
            togglePublished(){
                this.busy = true;
                axios.patch(App.basePath + 'users/' + this.user.id, {
                    is_published: !this.published,
                }).then((response) => {
                    this.busy = false;
                    this.published = response.data.is_published;
                });
            }
        },

        props: ['user']
    }
</script>