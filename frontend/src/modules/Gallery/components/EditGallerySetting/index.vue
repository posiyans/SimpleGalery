<template>
  <div class="q-gutter-sm">
    <div>
      <q-input
          v-model="gallery.name"
          label="Название"
          outlined
          class="bg-white"
      />
    </div>
    <div>
      <q-select
          outlined
          v-model="gallery.access"
          :options="typeAccess"
          label="Доступ"
          map-options
          emit-value
          class="bg-white"
      />
    </div>
    <div>
      <q-input v-model="name" outlined label="Родительская галерея" class="bg-white" >
        <q-popup-proxy cover transition-show="scale" transition-hide="scale">
          <q-banner>
            <GalleryTree :list="galleries" >
              <template v-slot:default="{prop}">
                <div class="row items-center">
                  <div>
                    {{prop.name}}
                  </div>
                  <div>
                    <q-radio :model-value="gallery.parent_id" :val="prop.id" v-close-popup @update:model-value="setParent(prop)"/>
                  </div>
                </div>
              </template>
            </GalleryTree>
          </q-banner>
        </q-popup-proxy>
      </q-input>
    </div>
    <div class="text-right">
      <q-btn color="secondary" no-caps label="Сохранить" @click="updateGallery"/>
    </div>
  </div>
</template>

<script>
import { gallery, typeAccess, galleries, updateGallery } from 'src/modules/Gallery/components/EditGallerySetting/editGallery'
import { onMounted, ref } from 'vue'
import { getGalleryTree } from 'src/modules/Gallery/api/galleryApi'
import GalleryTree from 'src/modules/Gallery/components/GalleryTree/index.vue'

export default {
  components: {
    GalleryTree
  },
  setup() {
    const name = ref('')
    onMounted(() => {
      console.log('mounted!!!')
      getGalleryTree()
        .then(res => {
          galleries.value = [
            {
              id: null,
              name: 'Без родителя',
              path: '',
              children: res.data
            }
          ]
          name.value = '!!!!'
        })
    })
    const setParent = (prop) => {
      gallery.value.parent_id = prop.id
      name.value = prop.name
    }
    return {
      updateGallery,
      setParent,
      name,
      galleries,
      gallery,
      typeAccess
    }
  }

}
</script>

<style scoped>

</style>
