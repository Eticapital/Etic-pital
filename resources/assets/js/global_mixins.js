let animationMixins = {
    methods: {
        collapseVerticalBeforeEnter: function (el) {
            el.style.height = 0;
            el.style.opacity = 0
            el.style.overflow = 'hidden'
        },

        collapseVerticalEnter: function (el, done) {
            el.style.height = null
            let finalHeight = el.offsetHeight
            el.style.height = 0

            Velocity(el, {
                opacity: 1,
                height: finalHeight,
            }, { duration: 150, complete: done });
        },

        collapseVerticalLeave: function (el, done) {
            Velocity(el, {
                opacity: 0,
                height: 0
            }, { duration: 150, complete: done })
        },

        collapseHorizontalBeforeEnter: function (el) {
            // Mantiene el tamaño de los elementos
            el.style.width = 0;
            el.style.opacity = 0
            el.style.overflow = 'hidden'
            el.style.display = 'block'
        },

        collapseHorizontalEnter: function (el, done) {
            el.style.width = null
            let finalWidth = el.offsetWidth
            el.style.width = 0

            Velocity(el, {
                opacity: 1,
                width: finalWidth,
            }, { duration: 150, complete: done });
        },

        collapseHorizontalLeave: function (el, done) {
            Velocity(el, {
                opacity: 0,
                width: 0
            }, { duration: 150, complete: done })
        },
    }
}


let crudMixins = {
    methods: {
        deleteModel(
            url,
            index,
            title = '¿Seguro deseas eliminar?',
            text = 'Esta acción no se puede deshacer',
            confirmButtonText = 'Estoy seguro',
            confirmationConfirmButtonText = 'Ok',
            confirmationTitle = 'Eliminado correctamente'
        ) {
            swal({
                title: title,
                text: text,
                showCancelButton: true,
                confirmButtonText: confirmButtonText,
                showLoaderOnConfirm: true,
                preConfirm() {
                    return axios.delete(App.basePath + url)
                }
            }).then(function (response) {
                if (response.dismiss==='cancel') {
                  return
                }
                Vue.nextTick(() => typeof this.loadData !== 'undefined' ? this.loadData() : this.items.splice(index, 1))
                swal({
                    title: confirmationTitle,
                    type: 'success',
                    confirmButtonText: confirmationConfirmButtonText,
                });
            }.bind(this));
        },
        deleteDataTable(
            props,
            resource,
            title = '¿Seguro deseas eliminar?',
            text = 'Esta acción no se puede deshacer',
            confirmButtonText = 'Estoy seguro',
            confirmationConfirmButtonText = 'Ok',
            confirmationTitle = 'Eliminado correctamente'
        ) {

            swal({
                title: title,
                text: text,
                showCancelButton: true,
                confirmButtonText: confirmButtonText,
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return App.delete(App.basePath + resource + '/' + props.rowData.id, new Form())
                }
            }).then(function () {
                Vue.nextTick(() => this.$refs.table ? this.$refs.table.refresh() : '')
                swal({
                    title: confirmationTitle,
                    type: 'success',
                    confirmButtonText: confirmationConfirmButtonText,
                });
            }.bind(this));
        },
        deleteDataTableUrl(
            url,
            title = '¿Seguro deseas eliminar?',
            text = 'Esta acción no se puede deshacer',
            confirmButtonText = 'Estoy seguro',
            confirmationConfirmButtonText = 'Ok',
            confirmationTitle = 'Eliminado correctamente'
        ) {
            swal({
                title: title,
                text: text,
                showCancelButton: true,
                confirmButtonText: confirmButtonText,
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return App.delete(App.basePath + url, new Form())
                }
            }).then(function () {
                Vue.nextTick(() => this.$refs.table ? this.$refs.table.refresh() : '')
                swal({
                    title: confirmationTitle,
                    type: 'success',
                    confirmButtonText: confirmationConfirmButtonText,
                });
            }.bind(this));
        },
    }
}

let permissionsMixins = {
    methods: {
        can (model, permissions) {
            return permissions.split('|').find(function (permission) {
                return model['can_' + permission];
            });
        },
        canDataTable (props, permissions) {
            return permissions.split('|').find(function (permission) {
                return props.rowData['can_' + permission];
            });
        }
    },
}

Vue.mixin(animationMixins)
Vue.mixin(crudMixins)
Vue.mixin(permissionsMixins)