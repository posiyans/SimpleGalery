<template>
  <q-dialog
      v-model="addPhotoShow"
      :maximized="isMobile"
      @hide="$emit('hide')"
  >
    <q-card>
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6">
          Загрузить файлы в альбом
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll row justify-center">
          <AddPhoto :gallery-id="galleryId"  @reload="$emit('reload')" />
      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script>
import AddPhoto from 'src/modules/Media/components/AddPhoto'
import { computed, ref } from 'vue'
import { useQuasar } from 'quasar'

export default {
  components: {
    AddPhoto
  },
  props: {
    galleryId: {
      type: Number,
      required: true
    }
  },
  setup() {
    const $q = useQuasar()
    const addPhotoShow = ref(true)
    const isMobile = computed(() => {
      return $q.platform.is.mobile
    })
    return {
      addPhotoShow,
      isMobile
    }
  }
}
</script>

<style scoped lang="scss">

</style>
