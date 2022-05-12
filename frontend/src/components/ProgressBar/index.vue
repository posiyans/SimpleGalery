<template>
  <div class="progress-block" :style="style">
  </div>
</template>

<script>
import { computed } from 'vue'

export default {
  props: {
    progress: {
      type: String,
      default: '0px'
    },
    status: String,
    height: {
      type: String,
      default: '2px'
    }
  },
  setup(props) {
    const style = computed(() => {
      const color = props.status === 'failed' ? 'background-color: red;' : ''
      return color + 'width: ' + props.progress + '; height:' + props.height
    })
    return {
      style
    }
  }

}
</script>

<style scoped>
  .progress-block {
    background-color: #009587;
  }
</style>
