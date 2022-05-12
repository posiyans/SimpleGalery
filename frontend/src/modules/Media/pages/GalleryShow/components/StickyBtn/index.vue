<template>
  <div>
    <q-page-sticky position="bottom-right" :offset="[18, 18]">
      <q-fab
        v-model="fabShow"
        vertical-actions-align="right"
        color="secondary"
        glossy
        size="10px"
        icon="keyboard_arrow_up"
        direction="up"
      >
        <q-fab-action label-position="left" color="primary" icon="add" label="Добавить" @click="addFoto" />
<!--        <q-fab-action label-position="left" color="orange" icon="get_app" label="Скачать" @click="dowmloadGalery" />-->
      </q-fab>
    </q-page-sticky>
    <AddPhotoDialog v-if="addPhotoShow" :gallery-id="galleryId" @hide="closeDialog"/>
  </div>
</template>

<script>
import { computed, ref } from 'vue'
import { useQuasar } from 'quasar'
import AddPhotoDialog from 'src/modules/Media/components/AddPhotoDialog'

export default
{
  components: {
    AddPhotoDialog
  },
  props: {
    galleryId: {
      type: Number,
      required: true
    }
  },
  setup(_, { emit }) {
    const $q = useQuasar()
    const fabShow = ref(false)
    const addPhotoShow = ref(false)
    const addFoto = () => {
      addPhotoShow.value = true
    }
    const isMobile = computed(() => {
      return $q.platform.is.mobile
    })
    const closeDialog = () => {
      console.log('close')
      addPhotoShow.value = false
      emit('reload')
    }
    const dowmloadGalery = () => {
      $q.dialog({
        title: 'Скачать',
        message: 'Скачать весь альбом?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        // console.log('>>>> OK')
      }).onOk(() => {
        // console.log('>>>> second OK catcher')
      }).onCancel(() => {
        // console.log('>>>> Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
    }
    return {
      fabShow,
      addFoto,
      dowmloadGalery,
      addPhotoShow,
      isMobile,
      closeDialog
    }
  }

}
</script>

<style scoped lang="scss">

</style>
