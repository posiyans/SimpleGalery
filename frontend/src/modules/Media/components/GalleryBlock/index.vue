<template>
  <div class="relative-position public-grid-item-preview"  :style="styleDiv" >
    <img
      :src="url"
      loading="lazy"
      :style="style"
    />
    <div v-if="isVideo" class="video-block_icon">
      <q-icon
        size="50px"
        name="play_circle_outline"
        class="text-white"
      />
    </div>

    <div class="video-block_title relative-position" @click.stop>
      {{item.name}}
    </div>
    <div class="video-block_info">
      <q-icon round  name="info" size="1.2rem" @click.stop="infoShow = true"/>
    </div>
    <div class="video-block_download-btn" >
      <q-icon round  name="get_app" size="1.2rem" @click.stop="download"/>
    </div>

    <q-dialog v-model="infoShow">
      <q-card>
        <q-card-section>
          <div class="text-h6">Info</div>
        </q-card-section>

        <q-card-section class="q-pt-none">
          <pre>
            {{ item }}
          </pre>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="OK" color="primary" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>

  </div>
</template>

<script>
import { addFolderInList, getGalleryImage } from 'src/modules/Media/api/file'
import { exportFile } from 'quasar'

export default {
  props: {
    item: {
      type: Object,
      required: true
    },
    h: Number,
    w: Number,
    preview: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      formAddShow: false,
      selected: '',
      rotate: 0,
      list: [],
      infoShow: false
    }
  },
  computed: {
    isVideo() {
      return this.item && this.item.type.split('/')[0] === 'video'
    },
    styleDiv() {
      // if (this.rotate > 0) {
      //   const w = this.h / this.item.ratio
      //   return 'height: ' + this.h + 'px; width: ' + w + 'px;'
      // }
      const w = this.h * this.item.ratio
      return 'height: ' + this.h + 'px; width: ' + w + 'px;'
    },
    style() {
      // const l = this.h - 2
      const tt = 'height: ' + this.h + 'px;'
      // if (this.rotate > 0) {
      //   const l = this.h / this.item.ratio
      // tt = 'height: ' + this.w + 'px; width: ' + this.h + 'px;'
      // }
      return 'transform: scale(1) rotate(0deg);' + tt
    },
    url() {
      if (this.preview) {
        return process.env.BASE_API + '/api/v1/medial/folders/get-gallery-image?id=' + this.item.id + '&preview=true'
      }
      return process.env.BASE_API + '/api/v1/medial/folders/get-gallery-image?id=' + this.item.id
    }
  },
  created() {
    // if (this.item.Orientation) {
    //   switch (this.item.Orientation) {
    //     case 3:
    //       this.rotate = 180
    //       break
    //     case 6:
    //       this.rotate = 90
    //       break
    //     case 8:
    //       this.rotate = 270
    //       break
    //   }
    // }
  },
  mounted() {
    // this.getData()
  },
  methods: {
    download() {
      getGalleryImage({ id: this.item.id })
        .then(res => {
          exportFile(this.item.name, res.data)
        })
    },
    addFolder() {
      const data = {
        path: this.selected
      }
      addFolderInList(data)
    },
    getData() {
      getGalleryImage({ id: this.item.id })
        .then(res => {
          this.list = res.data
        })
    }
  }
}
</script>

<style scoped lang="scss">
  .public-grid-item-preview {
    //height: 150px;
    padding: 1px;
    //margin: 2px;
    border-radius: 6px;
    overflow: hidden;
    img {
      //height: 150px;
    }
  }
  .video-block_icon {
    position: absolute;
    width: 100px;
    height: 60px;
    margin-left: -50px;
    margin-top: -25px;
    padding-top: 5px;
    background-color: grey;
    top: 50%;
    left: 50%;
    text-align: center;
    border-radius: 15px;
    opacity: 0.5;
    &:hover {
      opacity: 0.2;
    }
  }
  .video-block_title {
    position: absolute;
    height: 1.5rem;
    padding-top: 5px;
    background-color: #262626;
    color: white;
    font-size: 0.6rem;
    bottom: 0;
    left: 0;
    right: 0;
    text-align: center;
    opacity: 0.3;
    &:hover {
      opacity: 0.75;
    }
  }
  .video-block_info {
    position: absolute;
    bottom: 2px;
    left: 10px;
    opacity: 0.5;
    color: white;
    @media screen  and (max-width: 650px) {
      display: none;
    }
    &:hover {
      opacity: 1
    }
  }
  .video-block_download-btn {
    position: absolute;
    bottom: 2px;
    right: 10px;
    opacity: 0.5;
    color: white;
    @media screen  and (max-width: 650px) {
      display: none;
    }
    &:hover {
      opacity: 1
    }
  }

</style>
