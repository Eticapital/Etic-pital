<template>
  <div class="Files">
    <ul class="d-flex flex-column list-unstyled" v-if="files.length">
      <form-file
        v-for="(file, index) in files"
        v-if="!file.deleted"
        :key="file.id"
        :file="file"
        :max-file-size="maxFileSize"
        @remove="removeFile(file)"
      />
    </ul>
    <file-upload
      class="btn btn-secondary"
      post-action="/upload"
      :multiple="true"
      v-model="files"
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
    }
  },

  data () {
    return {
      files: [],
      headers: axios.defaults.headers.common
    }
  },

  computed: {
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
