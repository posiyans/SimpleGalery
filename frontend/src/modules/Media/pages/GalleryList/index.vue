<template>
  <div class="text-center items-center flex justify-center relative-position">
    <div v-for="item in list" :key="item.id" class="q-pa-sm cursor-pointer" @click="toGallery(item.id)">
      <GalleryPreviewBlock :item="item" />
    </div>
  </div>
</template>

<script>
import { fetchFolderList } from 'src/modules/Media/api/file'
import GalleryPreviewBlock from './components/GalleryPreviewBlock'

export default {
  components: {
    GalleryPreviewBlock
  },
  data() {
    return {
      list: []
    }
  },
  mounted() {
    this.getData()
  },
  methods: {
    toGallery(id) {
      this.$router.push('/gallery/' + id)
    },
    getData() {
      fetchFolderList()
        .then(res => {
          this.list = res.data
        })
    }
  }
}
</script>

<style scoped>

</style>
