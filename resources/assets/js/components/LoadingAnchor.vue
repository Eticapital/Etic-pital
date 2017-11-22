<template>
    <a href="javascript:;" @click.prevent="clicked">
        <template v-if="busy">
            <div class="text-center">
                <i class="icon-spinner spinner"></i>
            </div>
        </template>
        <slot v-else></slot>
      </a>
</template>

<script>
    export default {
        data() {
            return {
                busy: false
            }
        },

        methods: {
            clicked() {
                this.busy = true;
                this.$emit('click');
            }
        }
    }
</script>
