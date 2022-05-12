<template>
  <div class="q-gutter-md row items-start">
    <q-img
      :src="url"
      style="width: 200px;"
      fit="cover"
    >
      <div class="absolute-bottom text-subtitle1 text-center">
         lkjljklj
      </div>
    </q-img>
  </div>
</template>

<script>
import { addFolderInList, getGalleryImage } from 'src/modules/Media/api/file'

export default {
  props: {
    item: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      formAddShow: false,
      selected: '',
      list: []
    }
  },
  computed: {
    url() {
      return 'http://localhost/1.jpg?d=' + this.item.id
    }
  },
  mounted() {
  },
  methods: {
    addFolder() {
      const data = {
        path: this.selected
      }
      addFolderInList(data)
    },
    getData() {
      getGalleryImage({ id: this.item.id })
        .then(res => {
          this.list = res.data
        })
    }
  }
}
</script>

<style scoped>
.gallery-block {
  margin: 10px;
}
  .gallery-block img {
    width: 200px;
  }
</style>
