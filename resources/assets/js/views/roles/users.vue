<template>
	<div>
		<content-loading v-show="busy" :loading="busy"></content-loading>
        <no-results v-show="!busy&&!hasResults" :message-empty="'No hay ningún usuario registrado en este grupo. Utiliza el buscador arriba para buscar nuevos usuarios.'"></no-results>
        <div v-if="hasResults&&!busy">
			<media-list
				class="media media-list"
				v-for="(user, index) in items"
				:key="user.id"
			>
			<router-link :to="{ name: 'users.show',  params: { id: user.id } }">
				<img class="img-avatar d-flex align-self-start" :src="user.avatar_70_url" alt="">
			</router-link>

			<div class="media-body">

				<h5 class="mt-0">
					{{ user.name }}

					<user-toggle-button :user="user" :role="role"></user-toggle-button>
				</h5>

				<ul class="list-unstyled list-inline mb-0">
					<li class="list-inline-item">
						<a :href="'mailto:' + user.email">
							<i class="icon-envelop"></i>
							{{ user.email }}
						</a>
					</li>
				</ul><!-- /.list-unstyled -->
			</div>
		</media-list>

		<pagination  v-if="hasResults" :pagination="pagination" :callback="loadData" :options="paginationOptions"></pagination>
	</div>
</div>
</template>

<script>
import Pagination from '../../components/BootstrapPagination.vue';
import MediaList from '../../components/MediaList.vue';
import UserToggleButton from './_user_toggle_button';

export default {
	data: function () {
		return {
			busy: false,
			role: {},
			query: '',
			items: [],
			pagination: false,
			paginationOptions: {
				previousText: '&laquo;',
				nextText: '&raquo;',
				alwaysShowPrevNext: true
			}
		}
	},

	beforeRouteEnter (to, from, next) {
		axios.get(App.basePath + 'roles/' + to.params.id )
			.then((response) => {
				next(vm => {
					vm.role = response.data;
					bus.breadcrumbParams = { id: vm.role.id };
					bus.breadcrumbAttribs = { display_name: vm.role.display_name };
					bus.$emit('view-ready');

					vm.loadData();
				})
			}).catch((error) => {
				next(false)
			});
	},

	watch: {
		query: function (query) {
			this.pagination.current_page = 1;
			this.loadData();
		}
	},

	methods: {
		loadData(next) {
			this.$Progress.start();
			this.busy = true;

			let options = {
				params: {
					paginate: this.pagination.per_page,
					page: this.pagination.current_page,
					query: this.query,
				}
			};

			axios.get(App.basePath + 'roles/' + this.role.id + '/users', options)
				.then((response) => {
					this.items = response.data.data;
					this.pagination = response.data;
					this.$Progress.finish();
					this.busy = false;
				});
		},
	},

	computed:{
		hasResults () {
			if (!this.pagination) {
				return false;
			}

			if (typeof this.pagination.data == 'object') {
				return Object.keys(this.pagination.data).length;
			}

			return this.pagination.data.length;
		},
	},

	created() {
		bus.$on('header-query-set', (query) => {
			this.query = query;
		});
	},

	components: {
		Pagination,
		MediaList,
		UserToggleButton,
	},
}
</script>