<template>
    <div>
        <div class="data-table-container">
            <data-table
                :css="table.css"
                ref="table"
                :api-url="table.url"
                :fields="table.fields"
                :per-page="10"
                pagination-path=""
                :append-params="table.params"
                @vuetable:pagination-data="onPaginationData"
            >
                <template slot="actions" slot-scope="props">
                    <div class="btn-group  btn-group-sm"  v-if="canDataTable(props, 'permissions|users|update|delete')">

                        <router-link v-if="canDataTable(props, 'permissions')" class="btn btn-secondary" :to="{ name: 'roles.permissions',  params: { id: props.rowData.id } }">
                            <i class="icon-checkmark"></i> Permisos
                        </router-link>

                        <router-link v-if="canDataTable(props, 'users')" class="btn btn-secondary" :to="{ name: 'roles.users',  params: { id: props.rowData.id } }">
                            <i class="icon-group"></i> Usuarios
                        </router-link>

                        <router-link v-if="canDataTable(props, 'update')" class="btn btn-secondary" :to="{ name: 'roles.edit',  params: { id: props.rowData.id } }">
                            <i class="icon-pen"></i> Editar
                        </router-link>

                        <button v-if="canDataTable(props, 'delete')" @click.prevent="deleteDataTable(props, 'roles')" class="btn btn-danger">
                            <i class="icon-bin"></i>
                        </button>
                    </div>
                </template>
            </data-table>
        </div>
        <div class="data-table-pagination">
            <data-table-pagination-info ref="paginationInfo"></data-table-pagination-info>
            <data-table-pagination
                ref="pagination"
                @vuetable-pagination:change-page="onChangePage"
            ></data-table-pagination>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                form: new Form(),
                table: {
                    url: '/roles',
                    params: {
                        query: ''
                    },
                    css: {
                        tableClass: 'table table-striped table-bordered'
                    },
                    fields: [
                        {
                            name: 'display_name',
                            title: 'Nombre'
                        },
                        {
                            name: 'description',
                            title: 'Descripción'
                        },
                        {
                            name: '__slot:actions',
                            dataClass: 'data-table-actions'
                        }
                    ],
                }
            }
        },

        methods: {
            onPaginationData (paginationData) {
                this.$refs.pagination.setPaginationData(paginationData)
                this.$refs.paginationInfo.setPaginationData(paginationData)
            },
            onChangePage (page) {
              this.$refs.table.changePage(page)
            },
        },

        created() {
            bus.$on('header-query-set', function (query) {
                this.table.params.query = query;
                Vue.nextTick(() => this.$refs.table ? this.$refs.table.refresh() : '')
            }.bind(this));
        }
    }
</script>