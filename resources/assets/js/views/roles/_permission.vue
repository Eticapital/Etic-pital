<template>
    <li class="list-group-item" >
        <label class="custom-control custom-checkbox">
            <input
                type="checkbox"
                :value="moduleName + '.' + name"
                class="custom-control-input"
                v-model="$parent.checkedPermissions"
                @change="togglePermission"
            >
            <i style="margin: 3px 8px 0 -22px" class="icon-spinner spinner" v-if="busy"></i>
            <span class="custom-control-indicator" v-else></span>
            <span class="custom-control-description" v-text="label"></span>
        </label>
    </li>
</template>

<script>
    export default {
        data() {
            return {
                busy: false,
            }
        },

        methods: {
            togglePermission(event) {
                let value = event.target.value;
                let checked = event.target.checked;
                this.busy = true;
                axios.patch(App.basePath + 'roles/' + this.role.id + '/permissions/' + value, {
                    'checked': checked
                })
                .then(function (response) {
                    this.busy = false;
                }.bind(this)).catch(function (error) {
                    this.busy = false;
                });
            }
        },

        props: ['moduleName', 'label', 'name', 'role'],
    }
</script>