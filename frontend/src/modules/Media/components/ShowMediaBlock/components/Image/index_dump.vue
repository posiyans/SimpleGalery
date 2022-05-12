<template>
  <img
      :src="url"
      style="max-height: 100%; max-width: 100%;"
      :style="imgStyle"
      @mousedown="mousedown"
      @touchstart="mousedownt"
      @click="click"
  >
  <div style="position: absolute; top: 20px; right: 120px;">
    <q-btn round  icon="refresh" class="text-white" @click.stop="t" />
  </div>
</template>

<script>
import { imgStyle, loading, reset } from 'src/modules/Media/components/ShowMediaBlock/components/use/imgStyle'
export default {
  props: {
    item: Object,
    preload: Object
  },
  setup() {
    return {
      imgStyle,
      loading
    }
  },
  data() {
    return {
      rotate: 0,
      load: false,
      zoom: 1,
      countClick: 0,
      mouse: false,
      left: 0,
      top: 0,
      images: {}

    }
  },
  created() {
    if (this.item.Orientation) {
      switch (this.item.Orientation) {
        case 3:
          this.rotate = 180
          break
        case 6:
          this.rotate = 0
          break
        case 8:
          this.rotate = 270
          break
      }
    }
  },
  mounted() {
    console.log(loading)
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
    },
    style() {
      return 'margin-left: ' + this.left + 'px; margin-top: ' + this.top + 'px; transform: scale(' + this.zoom + ') rotate(' + this.rotate + 'deg);'
    }
  },
  methods: {
    preloadac() {
      const img = new Image()
      img.src = this.pr
      img.onload = () => {
        this.images[this.preload.id] = img
      }
    },
    // reset() {
    //   this.left = 0
    //   this.top = 0
    // },
    mousedownt(e) {
      console.log(e)
      console.log(e.targetTouches[0].pageX, e.targetTouches[0].pageY)
      let startX = e.targetTouches[0].pageX
      let startY = e.targetTouches[0].pageY
      const move = (e) => {
        console.log('move')
        this.left += e.targetTouches[0].pageX - startX
        startX = e.targetTouches[0].pageX
        this.top += e.targetTouches[0].pageY - startY
        startY = e.targetTouches[0].pageY
      }
      const up = (e) => {
        console.log(e.targetTouches[0].pageX, e.targetTouches[0].pageY)
        console.log('up')
        document.removeEventListener('touchmove', move, false)
        document.removeEventListener('touchend', up, false)
      }
      document.addEventListener('touchmove', move, false)
      document.addEventListener('touchend', up, false)
      e.preventDefault()
    },
    mousedown(e) {
      console.log(e)
      console.log(e.pageX, e.pageY)
      let startX = e.pageX
      let startY = e.pageY
      const move = (e) => {
        console.log('move')
        this.left += e.pageX - startX
        startX = e.pageX
        this.top += e.pageY - startY
        startY = e.pageY
      }
      const up = (e) => {
        console.log(e.pageX, e.pageY)
        console.log('up')
        document.removeEventListener('mousemove', move, false)
        document.removeEventListener('mousemove', up, false)
      }
      document.addEventListener('mousemove', move, false)
      document.addEventListener('mouseup', up, false)
      e.preventDefault()
    },
    click() {
      setTimeout(() => {
        this.countClick = 0
      }, 500)
      this.countClick++
      if (this.countClick > 1) {
        this.reset()
        if (this.zoom === 1) {
          this.zoom = 2
        } else if (this.zoom === 2) {
          this.zoom = 3
        } else {
          this.zoom = 1
        }
        this.countClick = 0
      }
    },
    t() {
      this.rotate += 90
    }
  }
}
</script>

<style scoped lang="scss">

</style>
