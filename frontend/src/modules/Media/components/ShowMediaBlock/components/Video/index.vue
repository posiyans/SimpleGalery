<template>
  <video :src="url" controls="controls" :style="imgStyle">
    <source :src="url" :type='item.type'>
  </video>
</template>

<script>
import { imgStyle, reset } from 'src/modules/Media/components/ShowMediaBlock/components/use/imgStyle'
export default {
  props: {
    item: Object
  },
  setup() {
    reset()
    return {
      imgStyle
    }
  },
  watch: {
    item: {
      deep: true,
      handler: function() {
        reset()
      }
    }
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
