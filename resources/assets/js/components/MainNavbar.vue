<script>
    import NavItem from './NavItem.vue';
    import NavNotificationItem from './NavNotificationItem.vue';
    import DropdownItem from './DropdownItem.vue';

    let dropdownMixins = require('../mixins').dropdownMixins;

    export default {
        data: function () {
            return {
                showProfileMenu: false,
                collapsed: false,
                main_nav_items: [],
                new_nav_items: [],
                user_nav_items: [],
            };
        },

        computed: {
            pageTitle() {
                return bus.pageTitle;
            },
            avatar() {
                return App.avatar ? App.avatar : null;
            },
        },

        methods: {
            toggleSideNav() {
                bus.$emit('toggle-sidenavbar');
            },

            toggleCollapsed() {
                bus.$emit('toggle-main-navbar');
            },

            toggleProfileMenu() {
                this.showProfileMenu = !this.showProfileMenu
                if (this.showProfileMenu) {
                    bus.$emit('main-navbar-dropdown-open', 'profile');
                }
            },

            logout() {
                axios.post('/logout').then((response) => {
                    window.location.replace('/');
                });
            },
        },

        created() {
            bus.$on('toggle-main-navbar', (collapsed = null) => {
                this.collapsed = (collapsed !== null) ? collapsed : !this.collapsed;
            });

            bus.$on('breadcrumb-updated', (links) => {
                let lastElement = links ? links.slice(-1)[0] : false;
                let top_links = (lastElement && lastElement.items) ? lastElement.items.filter(item => item.in_top_menu) : false;

                let prevElement = links ? links.slice(-2)[0] : false;

                if (prevElement && lastElement && lastElement.return ) {
                    let returnItem = {
                        text: 'Regresar',
                        route: prevElement.route,
                        icon: 'arrow-left'
                    }

                    if (top_links) {
                        top_links.unshift(returnItem);
                    } else {
                        top_links = [returnItem];
                    }
                }

                if (top_links) {
                    this.main_nav_items = top_links;
                } else {
                    this.main_nav_items = [];
                }

                if (this.new_nav_items.length) {
                    this.main_nav_items = this.main_nav_items.concat(this.new_nav_items);
                }
            });

            bus.$on('push-main-navbar-item', (item) => {
                this.new_nav_items.push(item);
                this.main_nav_items = this.main_nav_items.concat(this.new_nav_items);
            });
        },

        watch: {
            '$route': function () {
                this.new_nav_items = [];
            },
        },

        components: {
            NavItem,
            DropdownItem,
            NavNotificationItem
        },

        mixins: [dropdownMixins]
    }
</script>
