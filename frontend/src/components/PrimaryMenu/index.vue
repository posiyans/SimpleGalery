<template>
  <q-scroll-area class="fit">
    <q-list>
      <template
        v-for="(menuItem, index) in menuList"
        :key="index"
      >
        <MenuItem :item="menuItem" />
      </template>
    </q-list>
  </q-scroll-area>
</template>

<script>
import { menuList } from 'components/PrimaryMenu/MenuList'
import { useRouter } from 'vue-router'
import { leftDrawerOpen } from 'layouts/components/Drawer/drawer.js'
import MenuItem from 'components/PrimaryMenu/MenuItem'

export default {
  components: {
    MenuItem
  },
  setup() {
    const router = useRouter()
    const openLink = (link) => {
      router.push(link)
      leftDrawerOpen.value = false
    }
    return {
      menuList,
      openLink
    }
  }
}
</script>

<style scoped>

</style>
