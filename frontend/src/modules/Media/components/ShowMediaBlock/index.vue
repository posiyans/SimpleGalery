<template>
  <div>
    <div class="image-viewer__wrapper" style="z-index: 2000;">
      <div
          class="image-viewer__mask"
          :class="{opacity: !hideControl}"
          @click="hideControl = !hideControl"
      />
      <div class="image-viewer__canvas">
        <component :is="componentName" :item="showMedia" :preload="preloadMedia" />
      </div>
      <div v-show="hideControl" class="image-viewer__prev" >
        <q-btn round  icon="arrow_back_ios" class="text-white" @click.stop.prevent="prev"  />
      </div>
      <div v-show="hideControl" class="image-viewer__next">
        <q-btn round icon="arrow_forward_ios" class="text-white"  @click.stop.prevent="next" />
      </div>
      <ActionsBlock v-show="hideControl" />
    </div>
  </div>
</template>

<script>
import Image from './components/Image'
import Video from './components/Video'
import Error from './components/Error'
import { index, gallery, showMedia, preloadMedia } from 'src/modules/Media/use/useGallery'
import { prev, next, closeShowMedia, downloadShowMedia } from 'src/modules/Media/use/showAction'
import { computed, onUnmounted, ref } from 'vue'
import { useQuasar } from 'quasar'
import ActionsBlock from './components/ActionsBlock'

export default {
  components: {
    ActionsBlock
  },
  setup() {
    const $q = useQuasar()
    // onMounted(() => {
    //   $q.fullscreen.toggle()
    // })
    onUnmounted(() => {
      $q.fullscreen.exit()
    })
    const closeMedia = () => {
      $q.fullscreen.exit()
      closeShowMedia()
    }
    const hideControl = ref(true)
    const componentName = computed(() => {
      const type = showMedia.value.type.split('/')
      if (type[0] === 'video') {
        return Video
      } else if (type[0] === 'image') {
        return Image
      }
      return Error
    })
    return {
      hideControl,
      closeMedia,
      downloadShowMedia,
      componentName,
      index,
      showMedia,
      preloadMedia,
      gallery,
      next,
      prev
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
