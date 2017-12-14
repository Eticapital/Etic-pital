<template>
  <span class="File">
    <a class="File--link" :href="file.download_link">
      <i :class="'File--icon icon-' + file.icon"></i>
      <span class="File--name">{{file.name}}</span>
    </a>
    <span class="File--info">{{ file.size_mb | currency('', 2) }}MB</span>
  </span>
</template>

<style>
  .File--icon {
    font-size: 40px;
    margin-right: 10px;
  }
  .File--info {
    margin-left: auto;
  }
  .File {
    width: 100%;
  }
  .File,
  .File--link {
  display: flex;
  align-items: center;
  }
</style>

<script>
export default {
  props: {
    file: {
      type: Object,
      required: true
    }
  }
}
</script>