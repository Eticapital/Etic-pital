<template>
  <li class="File" >
    <i v-if="file.error" class="File__icon icon-file-empty text-danger"></i>
    <i v-else-if="isActive" class="File__icon icon-file-empty text-muted"></i>
    <i v-else :class="['File__icon', 'text-success', 'icon-file-empty']"></i>

    <span class="File__name">{{ file.name }}</span>

    <span v-if="file.error" class="File__iconstatus text-danger" v-b-tooltip.hover :title="errorMessage">
      <i class="icon-warning"></i>
      (más)
    </span>
    <i v-else-if="isActive" class="File__iconstatus icon-spinner spinner text-muted"></i>
    <i v-else class="File__iconstatus icon-checkmark text-success"></i>

    <a @click.prevent="doDelete" href="#" class="text-danger ml-auto"><i class="icon-bin"></i><span class="d-none d-lg-inline"> Eliminar</span></a>
  </li>
</template>

<script>
export default {

  props: {
    file: {
      type: Object,
      required: true
    },
    maxFileSize: {
      type: Number,
      required: true
    }
  },

  computed: {
    isActive () {
      if (this.file.project_id) {
        return false
      }
      return this.file.active|| !this.file.success
    },
    maxFileSizeFormatted () {
      return Math.floor(this.maxFileSize / (1024 * 1024)) + 'MB'
    },
    errorMessage () {
      if (!this.file.error) {
        return false
      }

      switch (this.file.error) {
        case 'size':
          return `El archivo es demasiado grande, el tamaño máximo permitido es de ${this.maxFileSizeFormatted}`
        case 'extension':
          return 'El tipo de archivo que intentas cargar no está permitido'
      }

      console.log(this.file.error)
      return 'Ocurrio un problema con el servidor, por favor vuelve a intentarlo o contacta al administrador'
    }
  },

  methods: {
    doDelete () {
      if (this.file.error) {
        return this.$emit('remove')
      }
      swal({
        title: '¿Estás seguro que deseas eliminar?',
        type: 'question',
        showCancelButton: true,
        confirmButtonText: 'Estoy seguro, eliminar',
      }).then((result) => {
        if (result.value) {
          this.$emit('remove')
        } else if (result.dismiss === 'cancel') {
          console.log("cancelado")
        }
      })
    }
  }
}
</script>

<style lang="scss">
@import "resources/assets/sass/globals";

.File {
  display: flex;
  align-items: center;
  padding: 10px;
  border-bottom: 1px solid $input-border-color;
}

.File__icon {
font-size: 48px;
color: $primary;
margin-right: 15px;
}

.File__iconstatus {
  margin-left: 15px;
}
</style>
