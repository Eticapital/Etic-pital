<template>
    <div class="content-loading" v-if="loading">
        <p class="content-loading-message">
            <i class="icon icon-spinner spinner"></i>
            <span v-text="message"></span>
        </p>
    </div>
</template>

<script>
    export default {
        props: {
            message: {
                type: String,
                default: 'Cargando...'
            },
            loading: {
                default: false
            },
        },
    }
</script>

<style lang="scss">
    .content-loading {
        text-align: center;
        font-size: 16px;
        .icon {
            font-size: 35px;
            display: block;
            clear: both;
            margin: 15px 0;
        }
    }
</style>