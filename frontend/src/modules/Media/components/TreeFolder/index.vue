<template>
  <div class="text-center items-center relative-position">
    <q-tree
      :nodes="list"
      :key="key"
      default-expand-all
      v-model:selected="selected"
      @update:selected="selectedChange"
      node-key="path"
      @lazy-load="onLazyLoad"
    >
      <template v-slot:default-header="prop">
        <div class="row items-center">
          <div class="">{{ prop.node.label }}</div>
          <div>
            <q-btn icon="add" round flat size="sm" @click="addFolder(prop.node)"></q-btn>
          </div>
        </div>
      </template>
    </q-tree>
  </div>
</template>

<script>
import { fetchFolderTree } from 'src/modules/Media/api/file'
import { ref, onMounted } from 'vue'
import { useQuasar } from 'quasar'

export default {
  setup (_, { emit }) {
    const $q = useQuasar()
    const selected = ref(null)
    const list = ref([])
    const key = ref(1)
    const getData = () => {
      fetchFolderTree()
        .then(res => {
          const children = []
          res.data.forEach(item => {
            item.lazy = true
            children.push(item)
          })
          list.value = [
            {
              label: 'Папки',
              path: '',
              children
            }
          ]
        })
    }
    const addFolder = (node) => {
      $q.dialog({
        title: 'Создать папку',
        message: 'Укажите имя папки?',
        prompt: {
          model: '',
          type: 'text' // optional
        },
        cancel: true,
        persistent: true
      }).onOk(data => {
        node.children.push({
          label: data,
          path: node.path + '/' + data,
          // lazy: true,
          children: []
        })
        key.value++
        // console.log('>>>> OK, received', data)
      }).onCancel(() => {
        // console.log('>>>> Cancel')
      }).onDismiss(() => {
        // console.log('I am triggered on both OK and Cancel')
      })
    }
    function onLazyLoad ({ node, key, done, fail }) {
      console.log('lazy!!')
      console.log(node.path)
      // console.log(key)
      // call fail() if any error occurs
      const data = {
        folder: node.path
      }
      fetchFolderTree(data)
        .then(res => {
          console.log(res.data)
          const data = []
          res.data.forEach(item => {
            item.lazy = true
            data.push(item)
          })
          done(data)
        })
    }
    const selectedChange = (val) => {
      console.log('ff')
      console.log(val)
      emit('selected', val)
    }
    onMounted(() => {
      getData()
    })
    return {
      selected,
      list,
      selectedChange,
      onLazyLoad,
      addFolder,
      key
    }
  }
}
</script>

<style scoped>

</style>
