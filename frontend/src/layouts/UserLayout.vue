<template>
  <q-layout view="lHh Lpr lFf">
    <q-header
      dense
      elevated
      class="bg-teal"
    >
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title>
          Галерея
        </q-toolbar-title>
        <div class="q-pa-md">
          <q-btn-dropdown
            flat
            color="white"
            :label="user.name"
          >
            <q-list>
              <Logout />
            </q-list>
          </q-btn-dropdown>
        </div>
      </q-toolbar>
    </q-header>

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

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import Logout from 'src/components/Auth/Logout'
import PrimaryMenu from 'src/components/PrimaryMenu'
import { computed, defineComponent, ref } from 'vue'
import { useStore } from 'vuex'

export default defineComponent({
  name: 'MainLayout',

  components: {
    Logout,
    PrimaryMenu
  },

  setup () {
    const $store = useStore()
    const leftDrawerOpen = ref(false)
    const user = computed(() => {
      return $store.state.user.info
    })
    return {
      user,
      leftDrawerOpen,
      toggleLeftDrawer () {
        leftDrawerOpen.value = !leftDrawerOpen.value
      }
    }
  }
})
</script>
