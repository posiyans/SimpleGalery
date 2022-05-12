<template>
  <div class="text-center q-pa-lg">
      Авторизация
  </div>
</template>

<script>
import { useRouter, useRoute } from 'vue-router'
import { useStore } from 'vuex'
import { LocalStorage } from 'quasar'
import { getCsrfCookie } from 'src/modules/Auth/api/token'
export default {
  setup() {
    const router = useRouter()
    const route = useRoute()
    const store = useStore()
    const token = route.query.token
    if (token) {
      console.log(token)
      LocalStorage.set('user_token', token)
      getCsrfCookie()
        .then(res => {
          LocalStorage.set('user_token', token)
          router.push('/')
          store.dispatch('user/getInfo')
            .then(() => {
              router.push('/')
            })
        })
    } else {
      router.push('/auth/login')
    }
    console.log(router)
    return {
      token
    }
  }
}
</script>

<style scoped>

</style>
