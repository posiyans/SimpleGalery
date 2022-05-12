<template>
  <q-card style="min-width: 500px;">
    <q-card-section>
      <div class="text-h6">Добавить папку</div>
    </q-card-section>

    <q-separator />

    <q-card-section style="max-height: 50vh" class="scroll">
      <TreeFolder @selected="setPath"/>
    </q-card-section>

    <q-separator />

    <q-card-actions align="right">
     <span class="q-ml-sm">
        {{ path }}
     </span>
      <q-space />
      <q-btn flat label="Отмена" no-caps color="negative" v-close-popup />
      <q-btn flat label="Добавить" no-caps color="primary" v-close-popup @click="addFolder"/>
    </q-card-actions>
  </q-card>
</template>

<script>
import TreeFolder from 'src/modules/Media/components/TreeFolder'
import { addFolderInList } from 'src/modules/Media/api/file'

export default {
  components: {
    TreeFolder
  },
  data() {
    return {
      path: null
    }
  },

  methods: {
    setPath(val) {
      this.path = val
    },
    addFolder() {
      if (this.path) {
        const data = {
          path: this.path
        }
        console.log(data)
        addFolderInList(data)
          .then(res => {
            this.$emit('reload')
          })
      }
    }
  }

}
</script>

<style scoped>

</style>
