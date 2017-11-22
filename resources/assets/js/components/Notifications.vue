<template>
<div class="Notifications dropdown-menu dropdown-menu-right" aria-labelledby="app-notifications">
    <div class="Notifications__header">
        <a class="Notifications__close" @click.prevent="hideNotifications"><i class="icon-cross"></i></a>
        <span class="float-xs-left">
            Notificaciones
        </span>
        <a href="" class="float-right" @click.prevent="markAllAsRead">
            Marcar como leídas
        </a>
    </div>

    <div class="Notifications__wrap">

        <VuePerfectScrollbar
            v-if="notifications.length"
            class="Notifications__scrollbar"
            @ps-y-reach-end="loadNotifications"
        >
            <ul class="Notifications__list">
                <notification :notification="notification" v-for="notification in notifications" :key="notification"></notification>
            </ul>
        </VuePerfectScrollbar>

        <p class="Notifications__empty" v-else-if="notificationsLoaded && !busy">
            <i class="icon-alarm-snooze"></i>
            No tienes ninguna notificación
        </p>

        <p v-if="busy" class="Notifications__loader">
            <i class="icon-spinner"></i>
            Cargando<wait-dots></wait-dots>
        </p>
    </div>

    <div class="Notifications__footer">
        <a href="#">Ver todas las notificaciones</a>
    </div>
</div>
</template>


<script>
    import Notification from './Notification.vue';
    import VuePerfectScrollbar from 'vue-perfect-scrollbar/index.vue'

    export default {
        data: function () {
            return {
                busy: false,
                notifications: [],
                notificationsLoaded: false,
                notificationsNextPage: 1,
                notificationsLastPage: 1,
                notificationsOffset: 0
            };
        },

        computed: {
            top() {
                return (this.$refs.Scrollbar) ? this.$refs.Scrollbar.top : 0;
            },
        },

        methods: {
            loadNotifications() {
                if (!this.busy && this.notificationsNextPage <= this.notificationsLastPage) {
                    this.busy = true;
                    axios.get('/notifications', {
                        params: {
                            page: this.notificationsNextPage,
                            offset: this.notificationsOffset
                        }
                    }).then(function (response) {
                        this.notifications = this.notifications.concat(response.data.data);
                        this.notificationsNextPage = response.data.current_page + 1;
                        this.notificationsLastPage = response.data.last_page;
                        this.busy = false;
                    }.bind(this));
                }
            },

            markAllAsRead () {
                axios.get('/notifications/read').then(function (response) {
                    _.each(this.notifications, function (notification) {
                        if (!notification.read_at) {
                            notification.read_at = moment().format();
                            bus.$emit('reset-notifications-count');
                        }
                    });
                }.bind(this));
            },

            hideNotifications () {
                bus.$emit('hide-notifications');
            },
        },

        mounted () {
            var initialize = _.once(this.loadNotifications)

            bus.$on('show-notifications', function (value) {
                initialize();
                this.notificationsLoaded = true;
            }.bind(this, initialize))

            bus.$on('new-notification', function (notification) {
                if (this.notificationsLoaded) {
                    // Le doy formato a la notificación segun llega en el arreglo
                    var data = {
                        created_at: moment().format(),
                        updated_at: moment().format(),
                        id: notification.id,
                        read_at: null,
                        type: notification.type,
                        data: notification,
                    }

                    this.notifications.unshift(data);

                    // Cuando se agregan las notificaciones manualmente
                    // Es necesario generar un offset para que en la paginación
                    // considere que ya hay algunos cargados
                    this.notificationsOffset++;
                }
            }.bind(this));
        },

        components: {
            Notification,
            VuePerfectScrollbar
        },
    }
</script>

<style lang="scss">
    @import "resources/assets/sass/globals";
    @import "node_modules/bootstrap/scss/_mixins.scss";

    .Notifications {
        width: 300px;
        border-radius: 5px;
        left: auto;
        padding-bottom: 0;

        &.dropdown-menu:after {
            right: 25px !important;
        }

        @include media-breakpoint-down(md) {
            background: #FFF !important;
            position: fixed !important;
            left: 0;
            top: 25px;
            margin: 0 25px;
            right: 0;
            bottom: inherit;
            width: inherit;
            z-index: $zindex-modal !important;
        }
    }

    .Notifications__overflow {
        @include media-breakpoint-up(lg) {
            display: none;
        }
        position: fixed;
        background: rgba(0, 0, 0, 0.5);
        width: 100%;
        height: 100%;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        z-index: $zindex-modal-backdrop;
    }

    .Notifications__close {
        @include media-breakpoint-up(lg) {
            display: none;
        }
        cursor: pointer;
        position: absolute;
        display: block;
        // border: 3px solid $primary;
        background: $brand-dark-primary;
        color: #FFF !important;
        height: 40px;
        width: 40px;
        line-height: 38px;
        text-align: center;
        font-size: 15px;
        border-radius: 50%;
        right: -20px;
        top: -20px;
    }

    .Notifications__list {
        padding: 0;
        margin: 0;
        list-style: none;
        display: block;
    }

    .Notifications__header,
    .Notifications__footer {
        font-size: 13px;
        color: $text-light;
    }

    .Notifications__header {
        border-bottom: 1px solid $gray-lighter;
        padding: 3px 15px 7px;
    }

    .Notifications__footer {
        text-align: center;
        border-top: 1px solid $gray-lighter;

        > a {
            display: block;
            padding: 10px 0;
            &:hover {
                background: $primary;
                color: $white;
                text-decoration: none;
                border-radius: 0 0 5px 5px;
            }
        }
    }

    .Notifications__empty {
        margin: 0;
        padding: 5px 15px;
        text-align: center;

        >i {
            margin: 10px auto;
            display: block;
            font-size: 30px;
            border-radius: 50%;
            background: $gray-lighter;
            color: $text-light;
            width: 60px;
            height: 60px;
            line-height: 60px;
            text-align: center;
        }
    }

    .Notifications__loader {
        border-top: 1px solid $gray-lighter;
        margin: 0;
        padding: 5px 15px;
        text-align: center;
        > span {
            position: absolute;
        }
    }

    .Notifications__scrollbar{
        height: 350px; // Default
        width: 100%;
        position: relative;
        margin: auto;
    }

</style>