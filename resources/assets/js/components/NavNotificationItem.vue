<template>
    <li :class="['nav-item', 'dropdown', (showNotifications) ? 'show' : null]">
      <a
        id="app-notifications"
        class="nav-link"
        href=""
        aria-haspopup="true"
        aria-expanded="false"
        @click.prevent="toggleDropdown('showNotifications')">
        <i :class="['icon icon-alarm', attention ? 'swing' : '']"></i>
        <span v-cloak v-if="countNotifications" v-text="countNotifications" class="badge"></span>
      </a>
      <notifications v-show="showNotifications"></notifications>
      <span class="Notifications__overflow" v-show="showNotifications"></span>
    </li>
</template>

<script>
    import Notifications from './Notifications.vue';
    let dropdownMixins = require('../mixins').dropdownMixins;

    export default {
        data: function () {
            return {
                showNotifications: false,
                countNotifications: 0,
                attention: false,
            };
        },

        watch: {
            countNotifications: function (value)  {
                if (value) {
                    this.attention = true;
                    setTimeout(function(){ this.attention = false }.bind(this), 2000);
                }
            },
        },

        methods: {
            setMaxHeight() {
                let el = this.$el.getElementsByClassName('Notifications')[0];
                let scrollbar = el.getElementsByClassName('Notifications__scrollbar')[0];

                // Si está oculto
                if (!this.showNotifications || typeof scrollbar == 'undefined') {
                    return false;
                }

                scrollbar.style.maxHeight = null;

                let position = el.getBoundingClientRect();
                let height = el.offsetHeight
                let headersHeight =
                    el.getElementsByClassName('Notifications__header')[0].offsetHeight
                    + el.getElementsByClassName('Notifications__footer')[0].offsetHeight

                let occupiedSpace = height + position.top;

                let windowHeight = window.innerHeight
                    || document.documentElement.clientHeight
                    || document.body.clientHeight;

                let maxOccupiedSpaceByScrollbar = windowHeight - headersHeight - position.top - 25;

                if (occupiedSpace > windowHeight) {
                    scrollbar.style.maxHeight = maxOccupiedSpaceByScrollbar + 'px';
                }
            },
        },

        mounted () {
            window.addEventListener('resize', this.setMaxHeight);
        },

        created() {
            axios.get('/notifications/count').then(function (response) {
                this.countNotifications = response.data;
            }.bind(this));

            bus.$on('new-notification', function (notification) {
                this.countNotifications++;
            }.bind(this));

            bus.$on('reset-notifications-count', function (notification) {
                this.countNotifications = 0;
            }.bind(this));

            bus.$on('main-navbar-dropdown-open', function (name) {
                if (typeof name != 'string' || (typeof name == 'string' && name != 'notifications')) {
                    this.showNotifications = false;
                }
            }.bind(this));

            bus.$on('hide-notifications', function () {
                this.showNotifications = false;
            }.bind(this));

            // La notificacion que se encarga de leer cuando se abre cualqueir "dropdown"
            // Si estamos hablando de el mismo elemento aprovecho para emitir los eventos
            // que se encargan de obtener las notificaciones
            bus.$on('dropdown-toggle-open', function (emitter) {
                if (this.showNotifications && emitter == this) {
                    bus.$emit('show-notifications');
                    bus.$emit('main-navbar-dropdown-open', 'notifications');
                }
            }.bind(this));
        },

        components: {
            Notifications,
        },

        mixins: [dropdownMixins]
    }
</script>