<template>
  <div class="q-pa-lg">
    <div class="flex justify-around">
      <div
        v-for="item in listFiler"
        :key="item"
        class="img-block"
      >
        <q-img
          :src="item"
          contain
          spinner-color="secondary"
        >
        </q-img>
      </div>
    </div>
  </div>
</template>

<script>
import { fetchFileList } from './../../api/file'

export default {
  filters: {
    urlFilter(val) {
      return process.env.BASE_API + '/api/v1/medial/files/get-file?file=' + val
    }
  },
  data() {
    return {
      list: []
    }
  },
  computed: {
    listFiler() {
      return this.list.map(item => process.env.BASE_API + '/api/v1/medial/files/get-file?file=' + item)
    }
  },
  created() {
    this.getList()
  },
  methods: {
    getList() {
      fetchFileList()
        .then(res => {
          this.list = res.data
        })
    }
  }
}
</script>

<style scoped>
.img-block {
  padding: 5px;
  min-height: 150px;
  min-width: 250px;
}
  .img-block img {

  }
</style>
