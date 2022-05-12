<template>
  <video :src="url" controls="controls" style="transform: scale(1) rotate(0deg); margin-left: 0px; margin-top: 0px; max-height: 99%; max-width: 99%;">
    <source :src="url" :type='item.type'>
  </video>
</template>

<script>
export default {
  props: {
    item: Object
  },
  data() {
    return {

    }
  },
  computed: {
    url() {
      return process.env.BASE_API + '/api/v1/medial/folders/get-gallery-image?id=' + this.item.id
    }
  }
}
</script>

<style scoped lang="scss">

</style>
