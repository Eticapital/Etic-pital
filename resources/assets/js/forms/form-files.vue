<template>
  <div class="Files">
    <div :class="{'Files--list': true, 'Files--list--error': form && form.errors.has(name)}">
      <ul class="d-flex flex-column list-unstyled" v-if="activeFiles.length">
        <form-file
          v-for="(file, index) in activeFiles"
          v-if="!file.deleted"
          :key="file.id"
          :file="file"
          :max-file-size="maxFileSize"
          @remove="removeFile(file)"
        />
      </ul>
      <p v-else>
        Sin documentos
      </p>
    <p v-if="form&&form.errors.has(name)" style="display: block" class="invalid-feedback" v-text="form.errors.get(name)"></p>
    </div>
    <file-upload
      :class="['btn', form && form.errors.has(name) ? 'btn-danger' : 'btn-secondary']"
      post-action="/upload"
      :multiple="true"
      v-model="files"
      :input-id="'file-' + name"
      :headers="headers"
      @input-filter="inputFilter"
      @input-file="inputFile"
      :size="maxFileSize"
      ref="upload">
      {{ btnText }}
    </file-upload>
  </div>
</template>

<script>
import FileUpload from 'vue-upload-component'
import FormFile from './form-files-file'

export default {
  components: {
    FileUpload,
    FormFile
  },

  props: {
    btnText: {
      type: String,
      default: 'Subir documentos'
    },
    value: {
      type: Array,
      default: [],
      required: false
    },
    form: Object,
    name: String
  },

  data () {
    return {
      files: [],
      headers: axios.defaults.headers.common
    }
  },

  computed: {
    activeFiles () {
      return this.files.filter(file => !file.deleted)
    },
    maxFileSize () {
      return App.maxFileSize || 25165824
    },
    formFiles () {
      return this.files
        .filter(file => {
          return Number.isInteger(file.id) || (file.response && file.response.type)
        })
        .map(file => {
          return {
            id: file.id || null,
            name: file.name,
            tmp_name: file.response && file.response.name ? file.response.name : null,
            deleted: file.deleted || false
          }
        })
    }
  },

  watch: {
    formFiles: {
      handler (files) {
        this.$emit('input', files)
      },
      deep: true
    },

    value: {
      handler (value) {
        if (this.form && this.name) {
          this.form.errors.clear(this.name)
        }
        value.forEach(item => {
          let index = this.files.findIndex(file => file.id === item.id)
          if (index === -1) {
            this.files.push(item)
          }
        })
      },
      deep: true
    }
  },

  created () {
    this.files = this.value || []
  },

  methods: {
    inputFilter (newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        // Before adding a file

        // Filter system files or hide files
        // 过滤系统文件 和隐藏文件
        if (/(\/|^)(Thumbs\.db|desktop\.ini|\..+)$/.test(newFile.name)) {
          return prevent()
        }

        // Filter php html js file
        // 过滤 php html js 文件
        if (/\.(php5?|html?|jsx?)$/i.test(newFile.name)) {
          return prevent()
        }
      }
    },

    inputFile (newFile, oldFile) {
      if (newFile && !oldFile) {
        this.manageNewFile(newFile)
      }

      if (newFile && oldFile) {
        this.manageFileUpdated(newFile, oldFile)
      }

      if (!newFile && oldFile) {
        this.manageFileRemoved(oldFile)
      }

      // Automatic upload
      if (Boolean(newFile) !== Boolean(oldFile) || oldFile.error !== newFile.error) {
        if (!this.$refs.upload.active) {
          this.$refs.upload.active = true
        }
      }
    },

    manageNewFile (newFile) {
      // console.log('add', newFile)
    },
    manageFileUpdated (newFile, oldFile) {
      // console.log('update', oldFile)
    },
    manageFileRemoved (oldFile) {
      // console.log('remove', oldFile)
    },

    removeFile (fileToRemove) {
      if (Number.isInteger(fileToRemove.id)) {
        let index = this.files.findIndex(file => {
          return file.id === fileToRemove.id
        })

        if (index >= 0) {
          Vue.set(this.files[index], 'deleted', true)
        }
      } else {
        this.$refs.upload.remove(fileToRemove)
      }
    }
  }
}
</script>
<style lang="scss">
  @import "resources/assets/sass/globals";
  .Files--list--error {
    border: 1px solid theme-color('danger');
  }
</style>
