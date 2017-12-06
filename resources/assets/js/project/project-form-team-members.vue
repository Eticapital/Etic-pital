<template>
  <div>
    <team-member
      v-for="(member, index) in members"
      :key="member.id"
      :member="member"
      :index="index"
      @changed="memberChanged"
      @remove="removeMember(index)"
    />
    <p><b-btn variant="secondary" @click.prevent="addMember">Agregar otro miembro</b-btn></p>
  </div>
</template>

<script>
import TeamMember from './project-form-team-members-member'

export default {
  components: {
    TeamMember
  },

  props: {
    value: {
      type: Array
    }
  },

  data () {
    return {
      members: []
    }
  },

  watch: {
    members: {
      handler (members) {
        this.$emit('input', members)
      },
      deep: true
    },

    value (value) {
      this.members = value || [{ id: uniqid(), links: null, name: '' }]
    }
  },

  created () {
    this.members = this.value || [{ id: uniqid(), links: null, name: '' }]
  },

  methods: {
    memberChanged (member, index) {
      Vue.set(this.members, index, member)
    },
    removeMember (index) {
      this.members.splice(index, 1)
    },
    addMember (member, index) {
      this.members.push({ id: uniqid(), links: [''], name: '' })
    }
  }
}
</script>
