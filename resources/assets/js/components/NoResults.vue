<template>
    <div class="no-results">
        <div class="no-results-message no-results-message-query" v-if="this.query">
            <p>
                <i :class="['icon', 'icon-' + iconSearch]"></i>
                <span v-text="messageSearch"></span>
            </p>
            <p v-if="showClearButton"><button class="btn btn-primary" @click.prevent="clearSearch">Borrar criterio de búsqueda</button></p>
        </div>
        <p class="no-results-message" v-else>
            <i :class="['icon', 'icon-' + iconSearch]"></i>
            <span v-text="messageEmpty"></span>
        </p>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                query: ''
            }
        },

        props: {
            messageSearch: {
                type: String,
                default: 'No se encontraron resultados con tu criterio de búsqueda'
            },
            messageEmpty: {
                type: String,
                default: 'No hay ningún elemento que mostrar'
            },
            iconSearch: {
                type: String,
                default: 'sad'
            },
            showClearButton: {
                default: true
            }
        },

        methods: {
            clearSearch() {
                bus.$emit('header-query-clear');
            }
        },

        created() {
            bus.$on('header-query-set',  (query) => {
                this.query = query;
            });
        }
    }
</script>

<style lang="scss">
    .no-results {
        text-align: center;
        .icon {
            font-size: 150px;
            display: block;
            clear: both;
            margin: 15px 0;
        }
    }
</style>