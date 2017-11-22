<template>
    <div class="TopNotifications" v-show="alerts.length">
        <transition-group
            name="bounce"
            enter-active-class="bounceInUp"
            leave-active-class=""
            tag="div"
        >
            <top-notification
                v-for="(alert, index) in alerts"
                :alert="alert"
                :key="alert.id || index"
                :duration="alert.duration ? alert.duration : duration"
                @remove="alerts.splice(index, 1)"
            ></top-notification>
        </transition-group>
    </div>
</template>

<script>
    import TopNotification from './TopNotification.vue';

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
            duration: {
                type: Number,
                default: 5000
            },
        },

        components: {
            TopNotification
        },

        created() {

            bus.$on('top-notification', (notification) => {
                this.alerts.push(notification);
            });

            bus.$on('clean-notifications', (notification) => {
                this.alerts = [];
            });
        }
    }
</script>