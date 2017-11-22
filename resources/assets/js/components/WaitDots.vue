<template>
    <span><slot></slot><span v-text="dots"></span></span>
</template>

<script>
    export default {
        data: function() {
            return {
                dots: '...',
                interval: null
            }
        },

        mounted () {
            this.interval = setInterval(function () {
                if (this.dots.length >= 3) {
                    this.dots = "";
                } else {
                    this.dots += ".";
                }
            }.bind(this), 500);
        },

        destroyed () {
            clearInterval(this.interval);
        },
    }
</script>