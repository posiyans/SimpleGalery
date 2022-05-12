<template>
  <div class="relative-position public-grid-item-preview" >
    <img
      :src="url"
      loading="lazy"
    />
    <div class="gallery-info">
      {{item.name}}
    </div>
  </div>
</template>

<script>

export default {
  props: {
    item: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      height: 250,
      saul: Date.now()
    }
  },
  computed: {
    style() {
      const width = this.height * 1.3
      return 'height: ' + this.height + 'px; width: ' + width + 'px;'
    },
    url() {
      return process.env.BASE_API + '/api/v1/medial/gallery/get-gallery-preview?id=' + this.item.id + '&sail=' + this.saul
    }
  },
  created() {
    if (this.$q.platform.is.mobile) {
      this.height = 110
    }
  },
  mounted() {
    let rnd = Math.floor(Math.random() * 5000) + 1500
    setInterval(() => {
      this.saul = Date.now()
      rnd = Math.floor(Math.random() * 5000) + 5000
    }, rnd)
  }
}
</script>

<style scoped lang="scss">
  .public-grid-item-preview {
    padding: 1px;
    border-radius: 6px;
    overflow: hidden;
  }
  .public-grid-item-preview, .public-grid-item-preview img {
    width: 320px;
    height: 250px;
    @media screen and (max-width: 800px) {
      width: 150px;
      height: 110px;
    }
  }
  .gallery-info {
    position: absolute;
    height: 50px;
    padding-top: 5px;
    background-color: #262626;
    color: white;
    font-size: 1.5rem;
    bottom: 0;
    left: 0;
    right: 0;
    text-align: center;
    opacity: 0.75;
    &:hover {
      opacity: 0.95;
    }
    @media screen and (max-width: 800px) {
      font-size: 0.8rem;
      padding-top: 0;
      height: 20px;
    }
  }

</style>
