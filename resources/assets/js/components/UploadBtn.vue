<template>
    <div>
        <button v-if="!success" :class="dropzoneClass" @click.prevent="">
            <dropzone
                id="myDropzone"
                ref="dropzone"
                :url="action"
                :headers="headers"
                :param-name="paramName"
                :maxFileSizeInmb="maxFileSizeInMB"
                :max-number-of-files="maxNumberOfFiles"
                :preview-template="previewTemplate"
                :show-remove-link="false"
                :language="language"
                :acceptedFileTypes="acceptedFileTypes"
                @vdropzone-success="uploadSuccess"
                @vdropzone-error="uploadError"
                @vdropzone-sending="uploadStarted"
            >
                <slot v-if="!busy"></slot>
            </dropzone>
        </button>

        <transition
            name="fade"
            enter-active-class="fadeIn"
            leave-active-class=""
        >
        <div class="UploadedBtn d-flex align-items-center" v-if="success">
            <div class="UploadedBtn--uploaded" :title="fileNameComplete">
                <span v-if="!hovered" class="UploadedBtn--name">
                    {{ fileNameShort }}<a v-if="fileNameShort!=fileNameComplete" @click.prevent="hovered=!hovered" href=""> ...</a>
                </span>
                <span v-else class="UploadedBtn--name">{{ fileNameComplete }}</span>
                <a href="" @click.prevent="reset" class="UploadedBtn--delete"><i class="icon-bin"></i></a>
            </div>
            <i class="ml-2 icon-checkmark text-success"></i>
        </div><!-- /.UploadedBtn -->
        </transition>


        <div v-if="errorMessage" class="form-control-feedback">
            {{ errorMessage }}
        </div>
    </div>
</template>

<script>
    import Dropzone from 'vue2-dropzone';

    export default {
        data() {
            return {
                errorMessage: null,
                hovered: false,
                file: null,
                uploadedFile: {},
                busy: false,
                paramName: 'file',
                maxFileSizeInMB: parseInt(App.maxFileSize / 1000000),
                maxNumberOfFiles: 1,
                previewTemplate: function () {
                    return `<div>
                        <div class="btn-progress progress">
                            <div class="progress-bar" role="progressbar" style="width: 0%" data-dz-uploadprogress>
                                <span data-dz-name></span>
                                <span data-dz-size></span>
                            </div>
                        </div>
                    </div>`
                },
                headers: {
                    'X-CSRF-TOKEN': App.csrfToken,
                },
                language: {
                    dictDefaultMessage: "Drop files here to upload",
                    dictFallbackMessage: "Tu navegador no soporta carga de archivos drag and drop",
                    dictFallbackText: "Please use the fallback form below to upload your files like in the olden days.",
                    dictFileTooBig: "El archivo es muy grande ({{filesize}}MB). El tamaño máximo permitido es: {{maxFilesize}}MiB.",
                    dictInvalidFileType: "No puedes subir archivos de ese tipo",
                    dictResponseError: "El servidor respondió con un código de error: {{statusCode}}.",
                    dictCancelUpload: "Cancelar carga",
                    dictCancelUploadConfirmation: "¿Estás seguro que quieres cancelar la carga?",
                    dictRemoveFile: "Eliminar archivo",
                    dictMaxFilesExceeded: "No puedes cargar más archivos",
                },
            }
        },

        props: ['btn-class', 'value', 'action', 'acceptedFileTypes'],

        methods: {
            reset() {
                this.errorMessage = false;
                this.file = null;
                this.hovered = false;
                // Esta nueva variable me ayuda a saber si
                // el archivo se eliminó, util si quiero borrar los archivos
                // en el servidor al guardar el formulario
                this.uploadedFile = {'deleted': true};
            },

            uploadSuccess: function (file, response) {
                this.uploadedFile = response;
                this.busy = false;
                this.file = file;
            },

            uploadStarted(file, xhr, formData) {
                this.errorMessage = null;
                this.busy = true;

                console.log(file, xhr, formData);
            },

            uploadError(file, response, d) {
                var errorMessage = 'Ocurrió un error desconocido, por favor vuelve a intentarlo o contacta a soporte.';
                if (typeof response == 'string') {
                    errorMessage = response;
                } else if (response.exception) {
                    if (response.exception == 'PostTooLargeException') {
                        errorMessage = 'El archivo es demasiado grande, el tamaño máximo es ' + this.$refs.dropzone.maxFileSizeInMB + 'MB'
                    }  else {
                        errorMessage = response.message ? response.message : response.error_default;
                    }
                }

                this.errorMessage = errorMessage;

                this.$refs.dropzone.removeFile(file);
                this.busy = false;

                this.file = null;

                this.$emit('error', errorMessage);
            },
        },

        computed: {
            success() {
                return this.uploadedFile.file_name;
            },

            dropzoneClass() {
                return [
                    this.btnClass,
                    this.busy ? 'btn-uploading' : '',
                    'btn-dropzone',
                    this.errorMessage ? 'btn-danger' : ''
                ];
            },

            fileName () {
                return this.uploadedFile.name ? this.uploadedFile.name : this.file.name;
            },

            fileNameShort () {
                if (this.fileName.length > 15) {
                    return this.fileName.substr(0, 15);
                }

                return this.fileName;
            },

            fileNameComplete () {
                return this.fileName;
            },
        },

        watch: {
            uploadedFile(uploadedFile) {
                if (typeof uploadedFile.is_new == 'undefined') {
                    uploadedFile['is_new'] = true;
                }

                this.$emit('input', uploadedFile);
            },

            value (value) {
                if (value && value.file_name) {
                    this.uploadedFile = this.value;
                }
            },
        },

        created() {
            if (this.value && this.value.file_name) {
                this.uploadedFile = this.value;
            }
        },

        components: {
            Dropzone
        },
    }
</script>

<style lang="scss">
    @import "resources/assets/sass/globals";

    .btn-progress {
        border: 2px solid $primary;
        background: #444;
        width: 165px;
        max-width: 100%;
    }
    .dz-complete .btn-progress{
        display: none;
    }

    .btn-dropzone {
        padding: 0;
        .dz-default {
            display: none;
        }
        .vue-dropzone {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: $input-btn-padding-y $input-btn-padding-x;
            border: 0 none;
            font-family: inherit;
            letter-spacing: inherit;
            color: inherit;
            transition: inherit;
            min-height: inherit;
            background: transparent;
            i {
                color: inherit;
            }
            &:hover {
                background: transparent;
            }
        }
    }

    .UploadedBtn--uploaded {
        display: inline-flex;
        border: 1px solid $primary;
        background: lighten($primary, 20);
        color: darken($primary, 20);
        padding: $input-btn-padding-y $input-btn-padding-x;
        border-radius: 5px;
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.175);
    }

    .UploadedBtn--delete {
        color: darken($primary, 20);
        margin-left: 10px;
        font-size: 1.2em;
    }
</style>