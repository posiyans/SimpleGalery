<template>
  <q-header
    dense
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
        <div class="cursor-pointer" @click="toIndex">
          {{ pageTitle }}
        </div>
      </q-toolbar-title>
      <div class="q-pr-md">
        <q-btn-dropdown
          flat
          dense
          no-caps
          color="white"
          :label="userName"
        >
          <q-list>
            <q-item
              v-close-popup
              clickable
            >
              <q-item-section>
                <q-item-label>
                  <Logout />
                </q-item-label>
              </q-item-section>
            </q-item>
          </q-list>
        </q-btn-dropdown>
      </div>
    </q-toolbar>
  </q-header>
</template>

<script>
import Logout from 'src/modules/Auth/components/Logout'
import { defineComponent } from 'vue'
import { toggleLeftDrawer } from 'layouts/components/Drawer/drawer.js'
import { pageTitle } from 'layouts/components/Header/header.js'
import { useRouter } from 'vue-router'
// import { useStore } from 'vuex'
import { userName } from 'src/hooks/userModel/userModel'

export default defineComponent({
  name: 'Header',
  components: {
    Logout
  },
  setup () {
    const router = useRouter()
    const toIndex = () => {
      router.push('/')
    }
    // const store = useStore()
    // const { userName } = userModel(store)
    return {
      userName,
      toIndex,
      pageTitle,
      toggleLeftDrawer
    }
  }
})
</script>
