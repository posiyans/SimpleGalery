<template>
  <div class="">
    <q-btn icon="add" outline round color="secondary" @click="formAddShow = true" />
    <div :key="key" style="">
      <q-tree
        :nodes="list"
        default-expand-all
        node-key="id"
        label-key="path"
      >
        <template v-slot:default-header="prop">
          <div class="row items-center">
            <div class="">{{ prop.node.path }}</div>
            <div v-if="!prop.node.children || prop.node.children.length === 0">
              <q-btn icon="clear" round flat size="10px" color="negative" @click="delFolder(prop.node)" />
            </div>
            <div v-if="false">
              <q-btn icon="swap_vert" round flat size="10px" color="primary" @click="changePatent(prop.node)" />
            </div>
          </div>
        </template>
      </q-tree>
    </div>
    <q-dialog v-model="formAddShow" >
      <AddFolder @reload="getData" />
    </q-dialog>
    <q-dialog v-model="selectParentShow" >
      <ChangeParent @reload="getData" />
    </q-dialog>
  </div>
</template>

<script>
import { fetchFolderList, addFolderInList, deleteFolderInList } from 'src/modules/Media/api/file'
import AddFolder from './componets/AddFolder'
import ChangeParent from './componets/ChangeParent'

export default {
  components: {
    AddFolder,
    ChangeParent
  },
  data() {
    return {
      formAddShow: false,
      selectParentShow: false,
      selected: '',
      list: [],
      key: 1
    }
  },
  mounted() {
    this.getData()
  },
  methods: {
    delFolder(folder) {
      this.$q.dialog({
        title: 'Удалить?',
        message: 'Вы точно хотите удалить галерею ' + folder.name,
        cancel: true,
        persistent: true
      }).onOk(() => {
        deleteFolderInList(folder.id)
          .then(() => {
            this.getData()
          })
      })
    },
    changePatent(node) {

    },
    addFolder() {
      const data = {
        path: this.selected
      }
      addFolderInList(data)
    },
    getData() {
      fetchFolderList()
        .then(res => {
          this.list = [
            {
              name: 'Галлереи',
              path: 'Галлереи',
              children: res.data
            }
          ]
          // this.list = res.data
          this.key++
        })
    }
  }
}
</script>

<style scoped>

</style>
