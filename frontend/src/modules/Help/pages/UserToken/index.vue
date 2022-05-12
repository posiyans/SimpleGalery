<template>
  <div class="text-center q-mt-lg">
    <div class="text-blue">
      Ссылка для авторизации по токену
    </div>
      <a :href="url" >
        <span class="text-h6 text-green">
          {{url}}
        </span>
      </a>
  </div>
</template>

<script>
import { computed, ref } from 'vue'
import { LocalStorage } from 'quasar'

export default {
  setup() {
    const token = ref(false)
    token.value = LocalStorage.getItem('user_token')
    const url = computed(() => {
      return window.location.origin + '/#/auth/login-by-token?token=' + token.value
    })
    return {
      token,
      url
    }
  }
}
</script>

<style scoped>

</style>
