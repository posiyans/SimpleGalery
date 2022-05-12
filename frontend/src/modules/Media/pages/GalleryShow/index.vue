<template>
  <div>
    <ShowMediaBlock v-if="index" />
    <div class="relative-position">
        <div v-for="(item,  index) in rowList" :key="index" class="cursor-pointer">
          <RowBlock :list="item" />
        </div>
    </div>
    <div v-intersection="loadMore" class="observer">
      <div id="observer-block" class="row justify-center q-my-md">
        <div style="height: 150px; padding-top: 50px">
          <q-spinner-dots  color="primary" size="40px" />
        </div>
      </div>
    </div>
    <StickyBtn :gallery-id="galleryId" @reload="getData"/>
  </div>
</template>

<script>
import ShowMediaBlock from 'src/modules/Media/components/ShowMediaBlock'
import RowBlock from 'src/modules/Media/pages/GalleryShow/components/RowBlock'
import StickyBtn from 'src/modules/Media/pages/GalleryShow/components/StickyBtn'

import { rowList, onResize, getData, loadMore, index, galleryId, setHeightImage } from 'src/modules/Media/use/useGallery'
import { onMounted, onUnmounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useQuasar } from 'quasar'
import { setIndexModel } from 'src/modules/Media/use/showAction'

export default {
  components: {
    RowBlock,
    ShowMediaBlock,
    StickyBtn
  },
  setup() {
    const route = useRoute()
    galleryId.value = route.params.id
    const $q = useQuasar()
    onMounted(() => {
      setHeightImage($q.platform.is.mobile ? 150 : 300)
      window.addEventListener('resize', onResize)
      onResize()
      getData()
      if (route.query && route.query.id) {
        setIndexModel(route.query.id)
      }
    })
    onUnmounted(() => {
      window.removeEventListener('resize', onResize)
    })
    watch(
      () => route.params.id,
      async newId => {
        galleryId.value = route.params.id
        getData()
      }
    )
    watch(
      () => index.value,
      () => {
        if (index.value == null) {
          history.pushState(
            {},
            null,
            `/#${route.path}`
          )
        }
      }
    )
    return {
      galleryId,
      rowList,
      index,
      getData,
      loadMore
    }
  }
}
</script>

<style scoped lang="scss">
</style>
