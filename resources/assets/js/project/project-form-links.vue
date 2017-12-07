<template>
  <div>
    <b-form-group
      :label="label"
      :feedback="form ? form.errors.get(name) : ''"
      :state="form && form.errors.has(name) ? 'invalid' : ''"
      ref="input"
    >
      <project-form-link
        v-for="(link, index) in links"
        :key="link.id"
        :index="index"
        :link="link.link"
        :total-links="links.length"
        :form="form"
        :name="name + '.' + index"
        @new-link="newLink"
        @remove-link="removeLink(index)"
        @input="updateLink"
      />
    </b-form-group>
  </div>
</template>

<script>
import ProjectFormLink from './project-form-links-link'

export default {
  components: {
    ProjectFormLink
  },

  props: {
    value: Array,
    label: String,
    form: Object,
    name: String
  },

  data () {
    return {
      links: []
    }
  },

  computed: {
    linksWithUniqueId () {
      let value = this.value ? this.value : ['']
      return value.map(link => {
        return {
          id: uniqid(),
          link: link
        }
      })
    }
  },

  watch: {
    value (value) {
      if (this.form && this.name) {
        this.form.errors.clear(this.name)
      }

      value.forEach((newLink) => {
        // Es un link nuevo
        if (this.links.findIndex(link => link.link === newLink) === -1) {
          // Si hay un link vacio lo inserto en ese link,
          // de lo contrario lo agrego como nuevo
          let emptyIndex = this.links.findIndex(link => link.link === '')
          if (emptyIndex >= 0) {
            this.links[emptyIndex].link = newLink
          } else {
            this.links.push({
              id: uniqid(),
              link: newLink
            })
          }
        }
      })

      // Por último siempre debe de haber un link "Vacio" para agregar nuevos
      // links
      let emptyIndex = this.links.findIndex(link => link.link === '')
      if (emptyIndex === -1) {
        this.links.push({
          id: uniqid(),
          link: ''
        })
      }
    },

    links: {
      handler (links) {
        let input = links
          .filter(link => {
            return link.link
          })
          .map(link => {
            return link.link
          })

        this.$emit('input', input)
      },
      deep: true
    }
  },

  created () {
    this.links = this.linksWithUniqueId
  },

  methods: {
    newLink () {
      this.links.push({
        id: uniqid(),
        link: ''
      })
    },
    removeLink (index) {
      this.links.splice(index, 1)
    },
    updateLink (index, value) {
      this.links[index].link = value
    }
  }
}
</script>


