<template>
  <div class="column q-pa-lg items-center">
    <div class="row">
      <LoginAndRegister :key="key"/>
    </div>
  </div>
</template>

<script>
import LoginAndRegister from 'src/modules/Auth/components/LoginAndRegister'
import { useRoute } from 'vue-router'
import { ref, watch } from 'vue'

export default {
  components: {
    LoginAndRegister
  },
  setup() {
    const route = useRoute()
    const key = ref(1)

    watch(
      () => route.query.token,
      () => {
        key.value++
      }
    )
    return { key }
  }
}
</script>

<style scoped>

</style>
