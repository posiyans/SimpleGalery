<template>
  <img :src="url" style="margin-left: 0px; margin-top: 0px; max-height: 100%; max-width: 100%;" :style="style">
  <div style="position: absolute; top: 20px; right: 120px;">
    <q-btn round  icon="refresh" class="text-white" @click.stop="t" />
  </div>
</template>

<script>
export default {
  props: {
    item: Object
  },
  data() {
    return {
      rotate: 0
    }
  },
  created() {
    if (this.item.Orientation) {
      switch (this.item.Orientation) {
        case 3:
          this.rotate = 180
          break
        case 6:
          this.rotate = 0
          break
        case 8:
          this.rotate = 270
          break
      }
    }
  },
  computed: {
    url() {
      return process.env.BASE_API + '/api/v1/medial/folders/get-gallery-image?id=' + this.item.id + '&t=' + this.item.name
    },
    style() {
      return 'transform: scale(1) rotate(' + this.rotate + 'deg);'
    }
  },
  methods: {
    t() {
      this.rotate += 90
    }
  }
}
</script>

<style scoped lang="scss">

</style>
