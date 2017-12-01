// Permite haces SPA
import VueRouter from 'vue-router';
Vue.use(VueRouter);

// Componentes de Bootstrap para VUe
import BootstrapVue from 'bootstrap-vue/dist/bootstrap-vue.esm';
Vue.use(BootstrapVue);

// Permite hacer peticiones ajax
import VueResource from 'vue-resource';
Vue.use(VueResource);

// Muestra una barra de progreso para SPA
import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar)

// Permite utilizar filtros en las vistas
import Vue2Filters from 'vue2-filters'
Vue.use(Vue2Filters)

// Permite usar moment como filtro
import VueMoment from 'vue-moment'
Vue.use(VueMoment)

// Data tables para
import { Vuetable } from 'vuetable-2';

Vue.component('vuetable', Vuetable);

Vue.component("data-table", require('./components/gui/DataTable'))
Vue.component("data-table-pagination", require('./components/gui/DataTablePagination'))

// import DatatablePagination from './components/gui/DataTablePagination'
// import DataTablePaginationInfo from './components/gui/DataTablePaginationInfo'
// import VuetablePaginationDropdown  from 'vuetable-2/src/components/VuetablePaginationDropdown.vue';

// ;
// Vue.component("data-table-pagination", DatatablePagination);
// Vue.component("data-table-pagination-info", DataTablePaginationInfo);
// Vue.component("data-table-pagination-dropdown", VuetablePaginationDropdown);

Vue.http.headers.common['X-CSRF-TOKEN'] = App.csrfToken;
