<template>
  <div v-if="showItem">
    <q-item
        v-ripple
        clickable
        @click="openLink(item.url)"
    >
      <q-item-section avatar>
        <q-icon :name="item.icon" />
      </q-item-section>
      <q-item-section>
        {{ item.label }}
      </q-item-section>
    </q-item>
    <q-separator
        v-if="item.separator"
    />
  </div>
</template>

<script>
import { useRouter } from 'vue-router'
import { leftDrawerOpen } from 'layouts/components/Drawer/drawer'
import { computed } from 'vue'
import { useStore } from 'vuex'

export default {
  props: {
    item: Object
  },
  setup(props) {
    const store = useStore()
    const showItem = computed(() => {
      if (props.item.roles && props.item.roles.indexOf(store.state.user.info.role) === -1) {
        return false
      }
      return true
    })
    const router = useRouter()
    const openLink = (link) => {
      router.push(link)
      leftDrawerOpen.value = false
    }
    return {
      showItem,
      openLink
    }
  }
}
</script>

<style scoped>

</style>
