<template>
    <div :class="[
        'DasboardAlert',
        'alert',
        'alert-' + alert.type,
        (alert.showCloseButton) ? 'alert-dismissible' : '',
        'show'
    ]" role="alert">
        <button @click="$emit('remove')" v-if="alert.showCloseButton" type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 v-if="alert.title" class="alert-heading" v-html="alert.title"></h4>
        <div v-if="alert.body" v-html="alert.body"></div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                show: true,
            }
        },
        props: ['alert', 'duration'],
        created(){
            setTimeout(function(){
                this.$emit('remove');
            }.bind(this), this.duration);
        }
    }
</script>