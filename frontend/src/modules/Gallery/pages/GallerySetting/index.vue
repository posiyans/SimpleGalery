<template>
  <div class="q-ma-lg">
    <div>
      <q-btn color="secondary" no-caps label="Добавить" @click="addNewGallery"/>
    </div>
    <GalleryTree v-if="load" :list="galleries" >
      <template v-slot:default="{prop}">
        <div class="row items-center">
          <div>
            {{prop.name}}
          </div>
          <div v-if="prop.id > 0">
            <q-btn icon="settings" round flat size="10px" color="primary"  @click="showdialog(prop)"/>
          </div>
        </div>
      </template>
    </GalleryTree>
    <q-dialog v-model="showSettingDialog">
      <q-card class="bg-indigo-1" style="min-width: 320px;">
        <q-card-section class="row items-center">
          <div class="text-h6">Галерея</div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>

        <q-card-section class="q-pt-none">
          <EditGallerySetting />
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
import { onMounted, ref } from 'vue'
import { getGalleryTree } from 'src/modules/Gallery/api/galleryApi'
import GalleryTree from 'src/modules/Gallery/components/GalleryTree/index.vue'
import EditGallerySetting from 'src/modules/Gallery/components/EditGallerySetting'
import { gallery } from 'src/modules/Gallery/components/EditGallerySetting/editGallery'

export default {
  components: {
    GalleryTree,
    EditGallerySetting
  },
  setup() {
    const load = ref(false)
    const galleries = ref([])
    const showSettingDialog = ref(false)
    const addNewGallery = () => {
      gallery.value = {
        name: '',
        access: '',
        parent_id: null
      }
      showSettingDialog.value = true
    }
    const showdialog = (prop) => {
      gallery.value = prop
      showSettingDialog.value = true
    }
    onMounted(() => {
      getGalleryTree()
        .then(res => {
          galleries.value = [
            {
              id: 0,
              name: '',
              path: '',
              children: res.data
            }
          ]
          load.value = true
        })
    })
    return {
      showdialog,
      addNewGallery,
      showSettingDialog,
      gallery,
      load,
      galleries
    }
  }
}
</script>

<style scoped>

</style>
