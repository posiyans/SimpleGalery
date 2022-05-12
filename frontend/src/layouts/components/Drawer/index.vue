<template>
  <q-drawer
    v-model="leftDrawerOpen"
    bordered
    class="bg-grey-1"
  >
    <q-list>
      <q-item-label
        header
        class="text-grey-8"
      >
        Меню
      </q-item-label>
    </q-list>
    <PrimaryMenu />
  </q-drawer>
</template>

<script>
import PrimaryMenu from 'src/components/PrimaryMenu'
import { defineComponent } from 'vue'
import { leftDrawerOpen } from 'layouts/components/Drawer/drawer.js'

export default defineComponent({
  name: 'Drawer',
  components: {
    PrimaryMenu
  },
  setup () {
    return {
      leftDrawerOpen
    }
  }
})
</script>
