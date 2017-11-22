<template>
    <div :class="[
        'TopNotification',
        'alert',
        'alert-' + alert.type,
        (alert.showCloseButton) ? 'alert-dismissible' : '',
        'show'
    ]" role="alert">
        <button @click="$emit('remove')" v-if="alert.showCloseButton" type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 v-if="alert.title" class="alert-heading" v-html="alert.title"></h4>

        <div v-if="alert.showIcon" class="d-flex align-items-center">
            <div class="alert-icon">
                <i :class="'icon icon-' + icon"></i>
            </div>
            <div v-html="alert.body"></div>
        </div>

        <div v-else v-html="alert.body"></div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                show: true,
                duration: 5000,
            }
        },

        props: ['alert'],

        computed: {
            icon() {
                switch (this.alert.type) {
                    case 'success':
                        return 'checkmark';
                    case 'danger':
                        return 'notification';
                    case 'warning':
                        return 'warning';
                }

                return 'info';
            },
        },

        created(){
            if (this.alert.duration) {
                setTimeout(() => {
                    this.$emit('remove');
                }, this.alert.duration );
            }
        }
    }
</script>

<style>
    .alert-icon {
        font-size: 30px;
        line-height: 1em;
        padding-right: 15px;
    }
</style>