<template>
  <div>
    <div>
      <q-toolbar class="text-primary bg-teal-1">
        <q-toolbar-title>
          {{ gallery.name }} ({{ list.length }})
        </q-toolbar-title>
        <q-btn flat round dense icon="add" @click="addFoto"/>
      </q-toolbar>
    </div>
    <ShowMediaBlock v-if="index !== null" :item="defItem" @changeIndex="changeIndex" @close="index = null" />
    <div class="text-center items-center relative-position">
        <div id="observer" class="flex justify-between" >
          <div  v-for="(item,  index) in showList" :key="item.id" class="cursor-pointer" @click="toGallery(index)">
            <GalleryBlock :item="item" />
          </div>
      </div>
    </div>
    <div id="observer-block" class="row justify-center q-my-md">
      <div style="height: 150px;">
        <q-spinner-dots  color="primary" size="40px" />
      </div>
    </div>
    <q-dialog v-model="addPhotoShow" :maximized="isMobile" @hide="getData">
      <AddPhoto :gallery-id="galleryId" @reload="getData"/>
    </q-dialog>
  </div>
</template>

<script>
import { getGalleryInfo, getImageListForGallery } from 'src/modules/Media/api/file'
import GalleryBlock from 'src/modules/Media/pages/GalleryList/components/GalleryBlock'
import AddPhoto from 'src/modules/Media/components/AddPhoto'
import ShowMediaBlock from 'src/modules/Media/components/ShowMediaBlock'
export default {
  components: {
    GalleryBlock,
    AddPhoto,
    ShowMediaBlock
  },
  data() {
    return {
      galleryId: null,
      addPhotoShow: false,
      formAddShow: false,
      selected: '',
      list: [],
      showImage: true,
      slide: 'first',
      dialog: false,
      index: null,
      gallery: {},
      showList: [],
      observer: null,
      listQuery: {
        page: 1,
        limit: 40,
        id: null
      }
    }
  },
  computed: {
    isMobile() {
      return this.$q.platform.is.mobile
    },
    url() {
      if (this.defItem) {
        return process.env.BASE_API + '/api/v1/medial/folders/get-gallery-image?id=' + this.defItem.id
      }
      return false
    },
    defItem() {
      if (this.list[this.index]) {
        return this.list[this.index]
      }
      return false
    }
  },
  created() {
    this.galleryId = this.$route.params && this.$route.params.id
    this.listQuery.id = this.galleryId
  },
  mounted() {
    this.getInfo()
    this.getData()
    const el = document.querySelector('#observer-block')
    this.observer = new IntersectionObserver(this.onLoad, {
      root: document.querySelector('desktop'),
      threshold: 1.0
    })
    this.observer.observe(el)
  },
  methods: {
    onLoad () {
      console.log('observer')
      this.listQuery.page++
      this.getData()
      // this.list.forEach(item => {
      //   if (i++ < 20) {
      //     this.showList.push(item)
      //   }
      // })
      // if (this.list.length < this.total) {
      //   this.queryList.page++
      //   this.getData()
      // }
    },
    scrollHandler(val) {
      console.log('scrollHandler')
      console.log(val)
    },
    addFoto() {
      this.addPhotoShow = true
    },
    closeImage() {
      this.index = null
      document.removeEventListener('keydown', this.eventKeyDown)
    },
    changeIndex(val) {
      this.index = this.index + val
      if (this.index >= this.list.length) {
        this.index = 0
      } else if (this.index < 0) {
        this.index = this.list.length - 1
      }
    },
    next() {
      this.index++
      if (this.index >= this.list.length) {
        this.index = 0
      }
    },
    prev() {
      this.index--
      if (this.index < 0) {
        this.index = this.list.length - 1
      }
    },
    eventKeyDown(event) {
      console.log(event.code)
      if (event.code === 'ArrowLeft') {
        this.prev()
      }
      if (event.code === 'ArrowRight') {
        this.next()
      }
      return true
    },
    toGallery(index) {
      this.index = index
      // document.addEventListener('keydown', this.eventKeyDown)
    },
    getInfo() {
      getGalleryInfo(this.galleryId)
        .then(res => {
          this.gallery = res.data
        })
    },
    getData() {
      getImageListForGallery(this.listQuery)
        .then(res => {
          // this.list = res.data.data
          res.data.data.forEach(item => {
            this.showList.push(item)
          })
        })
    }
  }
}
</script>

<style scoped lang="scss">
  .image-viewer__wrapper {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
  }
  .image-viewer__mask {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    opacity: .7;
    background: #000;
  }
  .image-viewer__prev {
    left: 40px;
    @media all and (max-width: 600px) {
      left: 5px;
    }
  }
  .image-viewer__prev button, .image-viewer__next button {
    @media all and (min-width: 601px) {
      background: #424242;
    }
  }
  .image-viewer__next {
    right: 40px;
    @media all and (max-width: 600px) {
      right: 5px;
    }
  }
  .image-viewer__close {
    right: 40px;
    position: absolute;
    top: 20px
  }
  .image-viewer__next, .image-viewer__prev {
    position: absolute;
    top: 50%;
  }
  .image-viewer__canvas {
    width: 100%;
    height: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
  }
  .custom-caption {
    text-align: center;
    padding: 12px;
    color: white;
    background-color: rgba(0, 0, 0, .3);
  }
</style>
