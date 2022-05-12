<template>
  <div @click="logout">
    Выход
  </div>
</template>

<script>
import { defineComponent } from 'vue'
// import { useStore } from 'vuex'
// import { useRouter } from 'vue-router'
import { logout } from 'src/hooks/userModel/userModel'

export default defineComponent({
  name: 'LogoutBlock',
  setup () {
    // const $router = useRouter()
    // const $store = useStore()
    // const { logout } = userModel($store, $router)
    return {
      logout
    }
  }
})
</script>

<style scoped>

</style>
