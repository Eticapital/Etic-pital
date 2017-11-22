<script>
    import VuePerfectScrollbar from 'vue-perfect-scrollbar'
    import SideNavItem from './SideNavItem.vue';
    import DropdownItem from './DropdownItem.vue';

    export default {
        data: function () {
            return {
                nav_items: [],
                open: false
            };
        },

        methods: {
            fetchNav() {
                axios.get('/nav').then(function (response) {
                    this.nav_items = response.data;
                    Vue.nextTick(function () {
                        bus.$emit('nav-loaded', this.nav_items);
                    }.bind(this));
                }.bind(this));
            },
        },

        computed: {
            pageTitle() {
                return App.title;
            },
        },

        created() {
            this.fetchNav();
        },

        components: {
            SideNavItem,
            DropdownItem,
            VuePerfectScrollbar
        }
    }
</script>