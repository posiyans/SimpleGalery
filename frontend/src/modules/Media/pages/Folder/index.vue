<template>
  <div class="text-center items-cente relative-position">
    <q-btn icon="add" outline round color="secondary" @click="formAddShow = true" />

    <div style="position: absolute; top: -40px; left: 0;right: 0;">
      <strong>
        {{ list }}
      </strong>
      <q-btn v-if="selected" no-caps label="Добавить" class="q-mx-lg" @click="addFolder"></q-btn>
    </div>
    <q-dialog v-model="formAddShow" >
      <AddFolder />
    </q-dialog>
  </div>
</template>

<script>
import { fetchFolderList, addFolderInList } from 'src/modules/Media/api/file'
import AddFolder from './componets/AddFolder'

export default {
  components: {
    AddFolder
  },
  data() {
    return {
      formAddShow: false,
      selected: '',
      list: []
    }
  },
  mounted() {
    this.getData()
  },
  methods: {
    addFolder() {
      const data = {
        path: this.selected
      }
      addFolderInList(data)
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
