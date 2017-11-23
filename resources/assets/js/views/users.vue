<template>
  <div>
    <content-loading v-show="busy" :loading="busy"/>
    <no-results v-show="!busy&&!hasResults" :message-empty="'No hay ningún usuario registrado.'"/>
    <div v-if="hasResults&&!busy">
      <media-list
      class="media media-list"
      v-for="(user, index) in pagination.data"
      :key="user.id"
      >
      <router-link v-if="can(user, 'view')" :to="{ name: 'users.show', params: { id: user.id } }">
        <img class="img-avatar d-flex align-self-start" :src="user.avatar_70_url">
      </router-link>

      <img v-else class="img-avatar d-flex align-self-start" :src="user.avatar_70_url">

      <div class="media-body">
        <media-more-menu v-if="can(user, 'update|delete')">

          <router-link v-if="can(user, 'update')" class="dropdown-item" :to="{ name: 'users.edit', params: { id: user.id } }">
            <i class="icon-pen"></i> Editar
          </router-link>

          <a v-if="can(user, 'delete')" class="dropdown-item" @click.prevent="deleteModel('users/' + user.id, index)" href="javascript:;">
            <i class="icon-bin"></i> Eliminar
          </a>

        </media-more-menu>

        <h5 class="mt-0">
          <router-link v-if="can(user, 'view')" :to="{ name: 'users.show', params: { id: user.id } }">
            {{ user.name }}
          </router-link>
          <span v-else>{{ user.name }}</span>
        </h5>

        <ul class="list-unstyled list-inline mb-0">
          <li class="list-inline-item">
            <published-toggle-link :user="user"/>
          </li>
          <li class="list-inline-item">
            <a :href="'mailto:' + user.email">
              <i class="icon-envelop"></i>
              {{ user.email }}
            </a>
          </li>
        </ul><!-- /.list-unstyled -->
      </div>
    </media-list>

    <pagination v-if="hasPages" :pagination="pagination" :callback="loadData" :options="paginationOptions"/>
  </div>
</div>
</template>

<script>
import BootstrapPagination from '../components/BootstrapPagination.vue'
import MediaMoreMenu from '../components/MediaMoreMenu.vue'
import MediaList from '../components/MediaList.vue'
import PublishedToggleLink from './users/_published_toggle_link'

export default {
  data: function () {
    return {
      busy: false,
      form: new Form(),
      items: [],
      query: '',
      pagination: false,
      paginationOptions: {
        previousText: '&laquo;',
        nextText: '&raquo;',
        alwaysShowPrevNext: true
      }
    }
  },

  computed: {
    hasPages () {
      if (!this.pagination) {
        return false
      }

      return this.pagination.last_page > 1
    },

    hasResults () {
      if (!this.pagination) {
        return false
      }

      if (typeof this.pagination.data === 'object') {
        return Object.keys(this.pagination.data).length
      }

      return this.pagination.data.length
    }
  },

  watch: {
    query: function (query) {
      this.pagination.current_page = 1
      this.loadData()
    }
  },

  methods: {
    loadData (next) {
      this.busy = true
      this.$Progress.start()

      let options = {
        requestId: 'users',
        params: {
          paginate: this.pagination.per_page,
          page: this.pagination.current_page,
          query: this.query
        }
      }

      axios.get(App.basePath + 'users', options).then((response) => {
        this.items = response.data.data
        this.pagination = response.data
        this.$Progress.finish()
        this.busy = false
      }).catch((thrown) => {
        if (!axios.isCancel(thrown)) {
          console.log(thrown)
          growl('Ocurrió un error al cargar los usuarios', 'danger')
        }
      })
    }
  },

  created () {
    this.loadData()

    bus.$on('header-query-set', (query) => {
      this.query = query
    })
  },

  components: {
    pagination: BootstrapPagination,
    MediaMoreMenu,
    MediaList,
    PublishedToggleLink
  }
}
</script>
