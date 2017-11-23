<template>
  <div>
  <b-form-group
    :label="label"
    :feedback="''"
    :state="''"
  >
    <project-form-link
      v-for="(link, index) in links"
      :key="link.id"
      :index="index"
      :link="link.link"
      :total-links="links.length"
      @new-link="newLink"
      @remove-link="removeLink(index)"
      @input="updateLink"
    />
  </b-form-group>
  <b-button
      v-if="links.length > 1"
      @click.prevent="newLink"
      size="sm"
      variant="secondary"
      class="mb-2"
    >
      Agregar link
    </b-button>
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
    label: String
  },

  data () {
    return {
      links: []
    }
  },

  computed: {
    linksWithUniqueId () {
      return this.value.map(link => {
        return {
          id: uniqid(),
          link: link
        }
      })
    }
  },

  watch: {
    links: {
      handler (links) {
        this.$emit('input', links.map(link => {
          return link.link
        }))
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
