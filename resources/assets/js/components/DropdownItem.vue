<template>
    <router-link class="dropdown-item" :to="to" v-text="link.text" @click.native="click"></router-link>
</template>

<script>
    export default {
        props: {
            'link': null,
        },

        methods: {
            click() {
                this.$emit('dropdown-item-clicked')
            }
        },

        computed: {
            to() {
                if (this.link.route) {
                    return { name: this.link.route, params: this.link.route_params }
                }

                return this.link.href;
            }
        },
    }
</script>
