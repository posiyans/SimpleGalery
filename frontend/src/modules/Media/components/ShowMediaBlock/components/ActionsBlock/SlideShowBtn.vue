<template>
  <q-btn flat round :icon="icon"  @click="togglePlay" />
</template>

<script>
import { computed, onUnmounted, ref } from 'vue'
import { next, play } from 'src/modules/Media/use/showAction'

export default {
  setup() {
    const time = 5000
    const timer = ref(false)
    const icon = computed(() => {
      return play.value ? 'pause_circle_outline' : 'play_circle_outline'
    })
    const togglePlay = () => {
      play.value = !play.value
      stopTimer()
      if (play.value) {
        timer.value = setInterval(() => {
          next()
        }, time)
      }
    }
    const stopTimer = () => {
      if (!play.value) {
        clearInterval(timer.value)
        timer.value = false
      }
    }
    onUnmounted(() => {
      clearInterval(timer.value)
      timer.value = false
    })
    return {
      icon,
      togglePlay
    }
  }
}
</script>

<style scoped>

</style>
