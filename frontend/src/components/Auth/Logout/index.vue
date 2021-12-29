<template>
  <q-item
    v-close-popup
    clickable
    @click="logout"
  >
    <q-item-section>
      <q-item-label>Выход</q-item-label>
    </q-item-section>
  </q-item>
</template>

<script>
import { defineComponent } from 'vue'
import { useStore } from 'vuex'
import { useRouter } from 'vue-router'

export default defineComponent({
  name: 'LogoutComponents',
  setup () {
    const $router = useRouter()
    const $store = useStore()
    function logout() {
      $store.dispatch('user/logout')
        .then(() => {
          $router.push('/auth/login')
        }).catch(error => {
          console.log(error)
        })
    }
    return {
      logout
    }
  }
})

</script>

<style scoped>

</style>
