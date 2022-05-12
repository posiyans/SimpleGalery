<template>
  <div>
    <div class="image-viewer__wrapper" style="z-index: 2000;">
      <div class="image-viewer__mask" :class="{opacity: !hideControl}" @click="hideControl = !hideControl"/>
      <div v-if="item" class="image-viewer__canvas">
        <component :is="componentName" :item="item" />
      </div>
      <div v-show="hideControl" class="image-viewer__close" >
        <q-btn round  icon="get_app" class="text-white" @click.stop="download"/>
        <q-btn round  icon="close" class="text-red" @click="closeImage" />
      </div>
      <div v-show="hideControl" class="image-viewer__prev" @click="prev" >
        <q-btn round  icon="arrow_back_ios" class="text-white" />
      </div>
      <div v-show="hideControl" class="image-viewer__next" @click="next">
        <q-btn round icon="arrow_forward_ios" class="text-white" />
      </div>
    </div>
  </div>
</template>

<script>

import { getGalleryImage } from 'src/modules/Media/api/file'
import { exportFile } from 'quasar'
import Image from './components/Image'
import Video from './components/Video'
export default {
  components: {
    Image
  },
  props: {
    item: Object
  },
  data() {
    return {
      hideControl: true
    }
  },
  computed: {
    componentName() {
      const type = this.item.type.split('/')
      if (type[0] === 'video') {
        return Video
      }
      return Image
    }
  },
  mounted() {
    document.addEventListener('keydown', this.eventKeyDown)
  },
  methods: {
    closeImage() {
      document.removeEventListener('keydown', this.eventKeyDown)
      this.$emit('close')
    },
    rotateAction() {

    },
    next() {
      this.$emit('changeIndex', 1)
    },
    prev() {
      this.$emit('changeIndex', -1)
    },
    eventKeyDown(event) {
      if (event.code === 'Space') {
        this.hideControl = !this.hideControl
      }
      if (event.code === 'ArrowLeft') {
        this.prev()
      }
      if (event.code === 'ArrowRight') {
        this.next()
      }
      return true
    },
    download() {
      getGalleryImage({ id: this.item.id })
        .then(res => {
          exportFile(this.item.name, res.data)
        })
    }
  }
}
</script>

<style scoped lang="scss">
  .image-viewer__wrapper {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
  }
  .image-viewer__mask {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    opacity: .9;
    background: #000;
  }
  .opacity {
    opacity: 1;
  }
  .image-viewer__prev {
    left: 40px;
    @media all and (max-width: 600px) {
      left: 5px;
    }
  }
  .image-viewer__prev button, .image-viewer__next button {
    @media all and (min-width: 601px) {
      background: #424242;
    }
  }
  .image-viewer__next {
    right: 40px;
    @media all and (max-width: 600px) {
      right: 5px;
    }
  }
  .image-viewer__close {
    right: 40px;
    position: absolute;
    top: 20px;
    opacity: .2;
  }
  .image-viewer__close:hover {
    opacity: 1;
  }
  .image-viewer__next, .image-viewer__prev {
    position: absolute;
    top: 50%;
  }
  .image-viewer__canvas {
    width: 100%;
    height: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
  }
  .custom-caption {
    text-align: center;
    padding: 12px;
    color: white;
    background-color: rgba(0, 0, 0, .3);
  }
</style>
