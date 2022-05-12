<template>
  <div :key="key" style="">
    <q-tree
        :nodes="list"
        default-expand-all
        node-key="id"
        label-key="path"
    >
      <template v-slot:default-header="prop">
        <slot :prop="prop.node" >
          <div class="row items-center">
            <div class="q-mr-md">{{ prop.node.name }}</div>
          </div>
        </slot>
      </template>
    </q-tree>
  </div>
</template>

<script>
import { ref } from 'vue'
export default {
  props: {
    list: Array
  },
  setup() {
    const key = ref(1)
    return {
      key
    }
  }
}
</script>

<style scoped>

</style>
