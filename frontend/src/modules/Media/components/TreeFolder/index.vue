<template>
  <div class="text-center items-center relative-position">
    <q-tree
      :nodes="list"
      accordion
      default-expand-all
      node-key="path"
      v-model:selected="selected"
      @lazy-load="onLazyLoad"
    />
  </div>
</template>

<script>
import { fetchFolderTree } from 'src/modules/Media/api/file'

export default {
  data() {
    return {
      selected: '',
      list: [
        {
          label: 'Папки'
        }
      ]
    }
  },
  mounted() {
    this.getData()
  },
  watch: {
    selected() {
      this.$emit('selected', this.selected)
    }
  },
  methods: {
    onLazyLoad ({ node, key, done, fail }) {
      // call fail() if any error occurs
      console.log('node')
      console.log(node)
      const data = {
        folder: node.path
      }
      fetchFolderTree(data)
        .then(res => {
          done(res.data)
        })
    },
    getData() {
      fetchFolderTree()
        .then(res => {
          this.list = [
            {
              label: 'Папки',
              path: '',
              children: res.data
            }
          ]
        })
    }
  }
}
</script>

<style scoped>

</style>
