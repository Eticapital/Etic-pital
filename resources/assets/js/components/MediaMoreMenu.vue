<template>
    <div class="media-list-more">
        <a href="javascript:;" @click="toggleDropdown('open')" class="media-list-more-link">
            <i class="icon-more"></i>
        </a>
        <ul class="media-list-more-list dropdown-menu dropdown-menu-right" v-if="open">
            <slot></slot>
        </ul>
    </div>
</template>

<script>
    let dropdownMixins = require('../mixins').dropdownMixins;

    export default {
        data: function () {
            return {
                open: false,
            }
        },

        mixins: [dropdownMixins],
    }
</script>

<style lang="scss">
    @import "resources/assets/sass/globals";
    @import "node_modules/bootstrap/scss/_mixins.scss";

    .media-list-more {
        float: right;
        position: relative;
        .media-list-more-link {
            display: block;
            font-size: 18px;
            &:hover {
                text-decoration: none;
            }
        }
    }

    .media-list-more-list {
        display: block !important;
    }
</style>