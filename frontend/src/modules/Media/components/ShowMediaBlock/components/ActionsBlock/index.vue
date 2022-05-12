<template>
  <div>
    <div class="actions-block">
      <div>
        <q-btn flat round icon="zoom_out" @click="handleActions('zoomOut')" />
      </div>
      <div>
        <q-btn flat round icon="zoom_in" @click="handleActions('zoomIn')" />
      </div>
      <q-space/>
      <div>
        <q-btn flat round :icon="mode.icon" @click="toggleMode"/>
      </div>
      <q-space/>
      <div>
        <q-btn flat round icon="rotate_left"  @click="handleActions('anticlockwise')" />
      </div>
      <div>
        <q-btn flat round icon="rotate_right" @click="handleActions('clockwise')" />
      </div>
    </div>
    <div v-if="loading" class="load-progress">
      <q-spinner-oval
          size="2em"
      />
    </div>
    <div class="close-block">
      <div>
        <q-btn flat round icon="check_box_outline_blank"  @click="fullScreen" />
      </div>
      <div>
        <SlideShowBtn />
      </div>
      <div>
        <q-btn flat round icon="get_app"  @click="downloadShowMedia" />
      </div>
      <q-space/>
      <div>
        <q-btn flat round icon="close" @click="closeMedia"/>
      </div>
    </div>
  </div>
</template>

<script>
import { handleActions, toggleMode, mode, registerEventListener, loading } from 'src/modules/Media/components/ShowMediaBlock/components/use/imgStyle'
import { onMounted } from 'vue'
import { closeShowMedia, downloadShowMedia } from 'src/modules/Media/use/showAction'
import { useQuasar } from 'quasar'
import SlideShowBtn from './SlideShowBtn'
export default {
  components: {
    SlideShowBtn
  },
  setup() {
    const $q = useQuasar()
    onMounted(() => {
      registerEventListener()
    })
    const fullScreen = () => {
      $q.fullscreen.toggle()
    }
    const closeMedia = () => {
      $q.fullscreen.exit()
      closeShowMedia()
    }
    return {
      closeMedia,
      downloadShowMedia,
      mode,
      loading,
      fullScreen,
      toggleMode,
      handleActions
    }
  }
}
</script>

<style scoped>
  .actions-block, .close-block {
    position: absolute;
    height: 44px;
    padding: 0 23px;
    background-color: grey;
    border-color: #fff;
    border-radius: 22px;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: .4;
    cursor: pointer;
    box-sizing: border-box;
    user-select: none;
    color: white;
  }
  .actions-block {
    left: 50%;
    bottom: 2px;
    transform: translate(-50%);
    width: 282px;
  }
  .actions-block:hover, .close-block:hover {
    opacity: .8;
  }
  .load-progress {
    position: absolute;
    left: 20px;
    top: 20px;
    color: white;
    opacity: 0.5;
  }
  .close-block {
    right: 20px;
    top: 10px;
  }
</style>
