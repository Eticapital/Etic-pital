require('./bootstrap');

require('./global_mixins');

require('./functions.js');

// Crud Forms
require('./forms/bootstrap');

// Módulos para Vue
require('./bootstrap_modules');

// Componentes Custom para la aplicación
Vue.component('main-navbar', require('./components/MainNavbar.vue'));
Vue.component('header-search-form', require('./components/HeaderSearchForm.vue'));
Vue.component('growl-notifications', require('./components/GrowlNotifications.vue'));
Vue.component('top-notifications', require('./components/TopNotifications.vue'));
Vue.component('side-navbar', require('./components/SideNavbar.vue'));
Vue.component('wait-dots', require('./components/WaitDots.vue'));
Vue.component('page-header', require('./components/PageHeader.vue'));
Vue.component('no-results', require('./components/NoResults.vue'));
Vue.component('content-loading', require('./components/ContentLoading.vue'));
Vue.component('loading-anchor', require('./components/LoadingAnchor.vue'));

// Form groups
Vue.component('form-text', require('./forms/form-text.vue'))
Vue.component('form-float', require('./forms/form-float.vue'))
Vue.component('form-money', require('./forms/form-money.vue'))
Vue.component('form-textarea', require('./forms/form-textarea.vue'))
Vue.component('form-checkbox', require('./forms/form-checkbox.vue'))

// Form inputs
Vue.component('input-float', require('./forms/input-float.vue'))

// // Rutas de la aplicación para Vue Router
import router from './router';
window.router = router;

// Para obtener y guardar variables globales
// Y generar eventos globales
window.bus = new Vue({
    data: function () {
        return {
            sideNavItems: [],
            breadcrumbParams: null,
            breadcrumbAttribs: null,
        };
    },

    computed: {
        breadcrumbLinks() {
            let routeName = this.$route.name;
            return _.findDeep(this.sideNavItems, { route: routeName });
        },

        currentPage() {
            if (this.breadcrumbLinks.length) {
                return this.breadcrumbLinks[this.breadcrumbLinks.length - 1];
            }

            return null
        },

        pageTitle() {
            let current = this.currentPage;
            return (current && current.title) ? format(current.title, this.breadcrumbAttribs) : App.title;
        },

        searchable() {
            let current = this.currentPage;
            return (current && current.searchable);
        },
    },

    methods: {
        isDesktop() {
            return (document.body.clientWidth >= 992);
        },
        isMobile() {
            return !this.is_desktop;
        }
    },

    watch: {
        pageTitle: function (title) {
            document.title = title ? title + ' - ' + App.title : App.title
        },
    },

    created() {
        this.$on('nav-loaded', (nav_items) => {
            this.sideNavItems = nav_items;
        });
    },

    router
});

require('./mixins');

// Creo mi app
const app = new Vue({
    el: '#app',

    data: {
        bodyClass: []
    },

    methods: {
        initEventListeners () {
            bus.$on('toggle-sidenavbar', function (open = null) {
                var idx = _.indexOf(this.bodyClass, 'open-sidebar')

                // Forzar cierre
                if (open === false) {
                    // Si esta abierto
                    if(idx!=-1) {
                        this.bodyClass.splice(idx, 1);
                    }

                    return false;
                }

                // Forzar abrirl
                if (open === true) {
                    // Si no está cerrado
                    if(idx == -1) {
                        this.bodyClass.push('open-sidebar');
                    }

                    return false;
                }

                if(idx !== -1) {
                    this.bodyClass.splice(idx, 1);
                } else {
                    this.bodyClass.push('open-sidebar');
                }
            }.bind(this))
        },
    },

    mounted() {
        this.$Progress.finish();

        this.initEventListeners();

        Echo.private('App.User.' + App.user.id)
            .notification((notification) => {
                bus.$emit('new-notification', notification);
            })
            .listen('GrowlNotification', (e) => {
                bus.$emit('growl-notification', e);
            });
    },

    created() {

        //  [App.vue specific] When App.vue is first loaded start the progress bar
        this.$Progress.start()
        //  hook the progress bar to start before we move router-view
        this.$router.beforeEach((to, from, next) => {
            bus.$emit('clean-notifications');
          //  does the page we want to go to have a meta.progress object
          if (to.meta.progress !== undefined) {
            let meta = to.meta.progress
            // parse meta tags
            this.$Progress.parseMeta(meta)
          }
          //  start the progress bar
          this.$Progress.start()
          //  continue to next page
          next()
        })
        //  hook the progress bar to finish after we've finished moving router-view
        this.$router.afterEach((to, from) => {
          //  finish the progress bar
          this.$Progress.finish()
        })
    },

    router
});
