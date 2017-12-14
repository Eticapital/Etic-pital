<template>
    <div :class="['form-group', avatarHasError ? 'has-danger' : '']">
        <div class="user-avatar">
            <img v-if="avatarTempUrl" class="avatar" :src="avatarTempUrl" />
            <img v-else class="avatar" :src="defaultAvatar" />
        </div>

        <vue-core-image-upload
            v-bind:class="['btn','btn-primary', (this.avatarLoading ? 'btn-loading' : ''), 'js-btn-crop', avatarHasError ? 'btn-danger' : '']"
            v-bind:crop="false"
            :url="avatarHandleUrl"
            extensions="png,gif,jpeg,jpg"
            :text="'Subir imagen del perfil'"
            inputOfFile="avatar"
            :headers="headers"
            :crop="true"
            :cropBtn="{ ok:'Guardar cambios','cancel':'Cancelar' }"
            :maxFileSize="maxFileSize"
            @imageuploading="imageUploading"
            @imageuploaded="imageUploaded"
            @errorhandle="errorHandle"
        ></vue-core-image-upload>

        <div v-if="avatarHasError" class="form-control-feedback text-center">
            {{ avatarHasError }}
        </div>
    </div>
</template>

<script>
    import VueCoreImageUpload  from 'vue-core-image-upload';

    export default {
        data() {
            return {
                avatarLoading: false,
                avatarHasError: '',
                avatarUrl: null,
                avatarName: null,
                headers: {
                    'X-CSRF-TOKEN': App.csrfToken,
                    'Accept': 'application/json'
                },
            }
        },

        props: ['currentAvatar'],

        methods: {
            imageUploaded(res, test) {
                // Significa que hubo error
                if (!res.url && res.avatar[0]) {
                    return this.errorHandle(res.avatar[0]);
                }
                this.avatarLoading = false;
                this.avatarHasError = null;
                this.avatarUrl = res.url;
                this.avatarName = res.name;
            },
            imageUploading(res) {
                this.avatarHasError = null;
                this.avatarLoading = true;
            },
            errorHandle(error) {
                this.avatarHasError = error;
                this.avatarLoading = false;
            },
        },

        computed: {
            avatarTempUrl() {
                if (this.avatarUrl) {
                    return this.avatarUrl;
                } else if (this.currentAvatar) {
                    return this.currentAvatar;
                }

                return null;
            },
            defaultAvatar() {
                return App.basePath + 'img/avatar/default@200.png'
            },
            avatarHandleUrl() {
                return App.basePath + 'users/avatar';
            },
            maxFileSize() {
                let max = 10485760; //10M
                return App.maxFileSize && App.maxFileSize < max ? App.maxFileSize : max; //10M
            }
        },

        watch: {
            'avatarName' : function (name) {
                this.$emit('avatar-changed', name);
            }
        },

        components: {
            VueCoreImageUpload,
        }
    }
</script>

<style lang="scss">
    @import "resources/assets/sass/globals";

    .g-core-image-upload-btn {
        display: block;
        width: 200px;
        max-width: 100%;
        margin: 0 auto;
    }

    .g-core-image-corp-container .btn-upload {
        border: 1px solid $primary !important;
        background: $primary !important;
    }

    .has-danger {
        .form-avatar {
            border-color: $danger;
        }
    }
</style>