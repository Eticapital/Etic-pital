<template>
    <div class="GrowlNotifications" v-show="alerts.length" :style="'max-width: ' + width + 'px'">
        <transition-group
            name="bounce"
            enter-active-class="bounceInUp"
            leave-active-class="bounceOutUp"
            tag="div"
        >
            <growl-notification
                v-for="(alert, index) in alerts"
                :alert="alert"
                :key="alert.id || index"
                :duration="alert.duration ? alert.duration : duration"
                @remove="alerts.splice(index, 1)"
            ></growl-notification>
        </transition-group>
    </div><!-- /.Alerts -->
</template>

<script>
    import GrowlNotification from './GrowlNotification.vue';

    export default {
        data: function () {
            return {
                alerts: this.initialAlerts,
            };
        },
        props: {
            initialAlerts: {
                default: function () {
                    return []
                },
                type: Array,
            },
            width: {
                type: Number,
                default: 700
            },
            duration: {
                type: Number,
                default: 5000
            },
        },

        components: {
            GrowlNotification
        },

        created() {
            bus.$on('growl-notification', function (notification) {
                this.alerts.push(notification);
            }.bind(this));
        }
    }
</script>

<style>
    .GrowlNotifications {
        z-index: 9999;
        position: fixed;
        right: 15px;
        top: 15px;
        min-width: 400px;
    }

    .GrowlNotifications--center {
        left: 0;
        right: 0;
        margin: 5% auto;
    }
</style>