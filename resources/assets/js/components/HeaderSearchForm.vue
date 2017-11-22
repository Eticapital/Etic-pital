<template>
    <div class="header-form-search">
        <div class="input-group">
          <input @keyup="search" v-model="query" class="form-control" type="text" placeholder="Buscar...">
          <span class="input-group-btn">
            <button @click.prevent="search" class="btn btn-secondary" type="button"><i class="icon-search"></i></button>
          </span>
          <span v-if="query" class="input-group-btn">
            <button @click.prevent="reset" class="btn btn-secondary" type="button"><i class="icon-cross"></i></button>
          </span>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                query:''
            }
        },

        methods: {
            search () {
                bus.$emit('header-query-set', this.query)
            },
            reset () {
                this.query = ''
                this.search();
                bus.$emit('header-query-reset', this.query)
            }
        },

        watch: {
            '$route': function () {
                this.query = '';
            },
        },

        created() {
            bus.$on('header-query-clear', function () {
                this.reset()
            }.bind(this));
        }
    }
</script>

<style lang="scss">
    @import "resources/assets/sass/globals";

    .header-form-search {
        float: right;
    }
</style>