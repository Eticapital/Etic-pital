<template>
    <div class="tiny_scrollbar">
        <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
        <div class="viewport">
             <div class="overview">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

<style lang="scss">
    @import "resources/assets/sass/globals";


    .tiny_scrollbar {
        width: 520px; margin: 20px 0 10px;

        .viewport {
            width: 500px;
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .overview {
            list-style: none;
            position: absolute;
            left: 0;
            top: 0;
            padding: 0;
            margin: 0;
        }

        .scrollbar{
            background: red;
            position: relative;
            background-position: 0 0;
            float: right;
            width: 15px;
        }

        .track {
            background: gray;
            height: 100%;
            width:13px;
            position: relative;
            padding: 0 1px;
        }

        .thumb {
            background: red;
            height: 20px;
            width: 25px;
            cursor: pointer;
            overflow: hidden;
            position: absolute;
            top: 0;
            left: -5px;

            .end {
                background: blue;
                overflow: hidden;
                height: 5px;
                width: 25px;
            }
        }

        .disable {
            display: none;
        }
    }

    .noSelect {
        user-select: none;
            -o-user-select: none;
        -moz-user-select: none;
        -khtml-user-select: none;
        -webkit-user-select: none;
    }
</style>
