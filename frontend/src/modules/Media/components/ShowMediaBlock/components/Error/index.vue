<template>
  <div
      :style="imgStyle"
  >
    yps
  </div>
</template>

<script>
import { imgStyle, loading, reset, handleMouseDown } from 'src/modules/Media/components/ShowMediaBlock/components/use/imgStyle'
export default {
  props: {
    item: Object,
    preload: Object
  },
  setup() {
    return {
      handleMouseDown,
      imgStyle,
      loading
    }
  },
  data() {
    return {
      load: false,
      images: {}
    }
  },
  mounted() {
    reset()
    loading.value = true
    const img = new Image()
    img.src = this.urlf
    img.onload = () => {
      console.log('load')
      loading.value = false
      this.load = true
    }
  },
  watch: {
    item: {
      deep: true,
      handler: function() {
        reset()
        this.zoom = 1
        this.load = false
        loading.value = true
        if (!this.images[this.item.id]) {
          const img = new Image()
          img.src = this.urlf
          img.onload = () => {
            console.log('load')
            this.load = true
            loading.value = false
          }
        } else {
          loading.value = false
          this.load = true
        }
        this.preloadac()
      }
    }
  },
  computed: {
    url() {
      if (this.load) {
        return process.env.BASE_API + '/api/v1/medial/folders/get-gallery-image?id=' + this.item.id + '&t=' + this.item.name
      }
      return process.env.BASE_API + '/api/v1/medial/folders/get-gallery-image?id=' + this.item.id + '&preview=true'
    },
    urlf() {
      return process.env.BASE_API + '/api/v1/medial/folders/get-gallery-image?id=' + this.item.id + '&t=' + this.item.name
    },
    pr() {
      return process.env.BASE_API + '/api/v1/medial/folders/get-gallery-image?id=' + this.preload.id + '&t=' + this.item.name
    }
  },
  methods: {
    preloadac() {
      const img = new Image()
      img.src = this.pr
      img.onload = () => {
        this.images[this.preload.id] = img
      }
    }
  }
}
</script>

<style scoped lang="scss">

</style>
