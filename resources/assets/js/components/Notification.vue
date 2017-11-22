<template>
    <li :class="{'Notification': true, 'Notification--not_readed': !notification.read_at}">
        <a class="Notification__link" :href="href">
            <span class="Notification__icon">
                <i :class="'icon-' + notification.data.icon"></i>
            </span>
            <span class="Notification__body">
                <span class="Notification__message" v-html="notification.data.message"></span>
                <span class="Notification__date" v-text="date"></span>
            </span>
        </a>
    </li>
</template>

<script>
    export default {
        computed: {
            date() {
                var date = moment(this.notification.updated_at);

                // si es el mismo día regreso el tiempo desde hoy
                if (date.isSame(moment(), 'day')) {
                    return date.fromNow();
                }

                return date.format('Do MMM YY h:mm:ss a');
            },

            href() {
                return '/notifications/' + this.notification.id + '/open';
            }
        },

        props: ['notification'],
    }
</script>

<style lang="scss">
    @import "resources/assets/sass/globals";

    .Notification {
        font-size: 13px;
        border-bottom: 1px solid $gray-lighter;
    }

    .Notification--not_readed {
        .Notification__link {
            background: lighten($primary, 45%);
        }
    }

    .Notification__link {
        padding: 15px;
        display: flex;
        align-items: flex-start;
        color: $body-color;
        &:hover,
        &.active {
            text-decoration: none;
            background: $primary;
            color: $white;

            .Notification__date,
            .Notification__icon,
            .Notification__body strong {
                color: $white;
            }

            .Notification__icon {
                background: lighten($primary, 10%);
            }
        }
    }

    .Notification__icon {
        display: flex;
        font-size: 25px;
        margin-right: 15px;
        border-radius: 50%;
        background: $gray-lighter;
        color: $text-light;
        > i {
           width: 38px;
           height: 38px;
           line-height: 38px;
           text-align: center;
        }
    }
    .Notification__body {
        flex: 1;
        strong {
            font-weight: normal;
            color: $primary;
        }
    }

    .Notification__message {
        display: block;
    }

    .Notification__date {
        color: $text-light;
        display: block;
        font-size: 10px;
        margin-top: 4px;
        text-transform: uppercase;
    }
</style>