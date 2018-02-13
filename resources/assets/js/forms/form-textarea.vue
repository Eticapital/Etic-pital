<template>
  <b-form-group
      :feedback="form.errors.get(name)"
      :state="form.errors.has(name) ? 'invalid' : ''"
      ref="group"
  >
    <span v-if="!tooltip" slot="label" v-html="label"></span>
    <span v-else slot="label">
      <span v-html="label"></span>
      <help-icon type="popover" :help="tooltip" />
    </span>
    <b-form-textarea
      v-if="!rich"
      :state="form.errors.has(name) ? 'invalid' : ''"
      v-model="form[name]"
      ref="input"
      :rows="rows"
      :placeholder="placeholder"
      :disabled="form.busy"
      @input="form.errors.clear(name)"
      @change="form.errors.clear(name)"
    />
    <quill-editor
      v-else
      ref="input"
      :class="{'quill-editor-invalid' : form.errors.has(name)}"
      v-model="form[name]"
      :options="editorOptions"
      @change="form.errors.clear(name)"
    />
    <!-- <wysiwyg
      v-else
      v-model="form[name]"
      ref="input"
      :rows="rows"
      :placeholder="placeholder"
      :disabled="form.busy"
      @input="form.errors.clear(name)"
      @change="form.errors.clear(name)"
    /> -->
  </b-form-group>
</template>

<script>
// require styles
import 'quill/dist/quill.core.css'
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

import { quillEditor } from 'vue-quill-editor'

export default {
  components: {
    quillEditor
  },

  data () {
    return {
      editorOptions: {
        placeholder: this.placeholder,
        modules: {
          toolbar: [
            ['bold', 'italic', 'underline', 'strike'], // toggled buttons
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['clean'] // remove formatting button
          ]
        }
      }
    }
  },

  computed: {
    editor() {
      if (this.rich) {
        return this.$refs.input.quill
      }
    }
  },

  props: {
    form: {
      type: Object,
      required: true
    },
    name: {
      type: String,
      required: true
    },
    label: {
      type: String,
      required: false
    },
    placeholder: {
      type: String,
      required: false
    },
    tooltip: {
      type: String,
      required: false
    },
    rows: {
      type: Number,
      required: false,
      default: 3
    },
    rich: {
      type: Boolean,
      default: false
    }
  }
}
</script>

<style>
.ql-container {
  font-family: "Open Sans", sans-serif;
  font-size: 1.125rem;
  font-weight: 400;
  line-height: 1.5;
  color: #4C4E52;

}
.ql-editor {
  min-height: 180px
}
.ql-container strong {
  font-weight: bold;
}
.ql-container p {
  margin-bottom: 1rem;
}
.quill-editor {
  background: #FFF;
}

.quill-editor-invalid .ql-toolbar,
.quill-editor-invalid .ql-container{
border-color: #dc3545;
}

</style>
