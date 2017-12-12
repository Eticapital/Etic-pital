<template>
  <b-card v-if="user" title="Actualizar mis datos de usuario">
    <account-form :user="user" />
  </b-card>
</template>

<script>

import AccountForm from '../../components/account/account-form'

export default {
  components: {
    AccountForm
  },

  data: function () {
    return {
      user: null
    }
  },

  beforeRouteEnter (to, from, next) {
    axios.get(App.basePath + 'account')
      .then((response) => {
        next(vm => {
          vm.user = response.data
          bus.$emit('view-ready')
        })
      }).catch((error) => {
        console.log(error)
        next(false)
      })
  }
}
</script>
