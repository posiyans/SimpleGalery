<template>
  <div class="flex justify-center">
    <div v-for="item in list.items" :key="item.id">
      <GalleryBlock :item="item" :h="list.h" @click="resetAndShow(item.id)"/>
    </div>
  </div>
</template>

<script>
import GalleryBlock from 'src/modules/Media/components/GalleryBlock'
import { setIndex, closeShowMedia } from 'src/modules/Media/use/showAction'
import { useQuasar } from 'quasar'
import { useRoute } from 'vue-router'

export default {
  components: {
    GalleryBlock
  },
  props: {
    list: {
      type: Object,
      required: true
    }
  },
  setup() {
    const $q = useQuasar()
    const route = useRoute()
    const changeUrl = (id) => {
      history.pushState(
        {},
        null,
        `/#${route.path}?id=${id}`
      )
    }
    const resetAndShow = (id) => {
      changeUrl(id)
      closeShowMedia()
      $q.fullscreen.exit()
      setIndex(id)
    }
    return {
      resetAndShow
    }
  },
  data() {
    return {
      formAddShow: false,
      selected: ''
    }
  }
}
</script>

<style scoped>
</style>
