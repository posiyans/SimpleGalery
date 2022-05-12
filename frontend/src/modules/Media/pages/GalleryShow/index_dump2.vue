<template>
  <div>
<!--    <ShowMediaBlock v-if="index !== null" :item="defItem" @changeIndex="changeIndex" @close="index = null" />-->
    <ShowMediaBlock v-if="index !== null" />
    <div class="relative-position">
        <div v-for="(item,  index) in rowList" :key="index" class="cursor-pointer">
          <RowBlock :list="item" @setIndex="toGallery"/>
        </div>
    </div>
    <div id="observer-block" class="row justify-center q-my-md">
      <div v-if="!allDownload" style="height: 150px; padding-top: 50px">
        <q-spinner-dots  color="primary" size="40px" />
      </div>
    </div>
    <StickyBtn :gallery-id="galleryId" @reload="reloadData"/>
  </div>
</template>

<script>
import { getGalleryInfo, getImageListForGallery } from 'src/modules/Media/api/file'
// import ShowMediaBlock from 'src/modules/Media/components/ShowMediaBlock'
import RowBlock from 'src/modules/Media/pages/GalleryShow/components/RowBlock'
import { pageTitle } from 'layouts/components/Header/header.js'

import StickyBtn from 'src/modules/Media/pages/GalleryShow/components/StickyBtn'

import { gallery, rowList, onResize, getData, index } from 'src/modules/Media/use/useGallery'
import { onMounted } from 'vue'

export default {
  components: {
    // GalleryBlock,
    RowBlock,
    // ShowMediaBlock,
    StickyBtn
  },
  setup() {
    onMounted(() => {
      console.log('onmounterd')
      onResize()
      getData()
    })
    return {
      index,
      gallery,
      rowList
    }
  },
  // data() {
  //   return {
  //     fabRight: false,
  //     galleryId: null,
  //     addPhotoShow: false,
  //     formAddShow: false,
  //     selected: '',
  //     allList: {},
  //     list: [],
  //     showImage: true,
  //     slide: 'first',
  //     dialog: false,
  //     // index: null,
  //     // gallery: {},
  //     showList: [],
  //     observer: null,
  //     row: [],
  //     total: 0,
  //     heightImage: 300,
  //     width: window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,
  //     listQuery: {
  //       page: 1,
  //       limit: 20,
  //       id: null
  //     }
  //   }
  // },
  // computed: {
  //   allDownload() {
  //     return !(this.total > this.allList.length)
  //   },
  //   isMobile() {
  //     return this.$q.platform.is.mobile
  //   },
  //   url() {
  //     if (this.defItem) {
  //       return process.env.BASE_API + '/api/v1/medial/folders/get-gallery-image?id=' + this.defItem.id
  //     }
  //     return false
  //   },
  //   defItem() {
  //     if (this.allList[this.index]) {
  //       return this.allList[this.index]
  //     }
  //     return false
  //   }
  // },
  // created() {
  //   this.galleryId = this.$route.params && +this.$route.params.id
  //   this.listQuery.id = this.galleryId
  // },
  // beforeUnmount() {
  //   window.removeEventListener('resize', this.onResize)
  //   this.setTitlePage('Галерея')
  // },
  // mounted() {
  //   this.heightImage = this.isMobile ? 150 : 300
  //   // this.getInfo()
  //   // this.getData()
  //   const el = document.querySelector('#observer-block')
  //   this.observer = new IntersectionObserver(this.onLoad, {
  //     root: document.querySelector('desktop'),
  //     rootMargin: '700px',
  //     threshold: 0.1
  //   })
  //   this.observer.observe(el)
  //   window.addEventListener('resize', this.onResize)
  // },
  // methods: {
  //   dowmloadGalery() {
  //     this.$q.dialog({
  //       title: 'Скачать',
  //       message: 'Скачать весь альбом?',
  //       cancel: true,
  //       persistent: true
  //     }).onOk(() => {
  //       // console.log('>>>> OK')
  //     }).onOk(() => {
  //       // console.log('>>>> second OK catcher')
  //     }).onCancel(() => {
  //       // console.log('>>>> Cancel')
  //     }).onDismiss(() => {
  //       // console.log('I am triggered on both OK and Cancel')
  //     })
  //   },
  //   onResize() {
  //     this.width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth
  //     this.heightImage = this.isMobile ? 150 : 300
  //     this.createRow()
  //   },
  //   onLoad () {
  //     // setTimeout(() => {
  //     //   this.listQuery.page++
  //     //   this.getData()
  //     // }, 100)
  //   },
  //   addFoto() {
  //     this.addPhotoShow = true
  //   },
  //   closeImage() {
  //     this.index = null
  //     document.removeEventListener('keydown', this.eventKeyDown)
  //   },
  //   changeIndex(val) {
  //     this.index = this.index + val
  //     if (this.index >= this.allList.length) {
  //       this.index = 0
  //     } else if (this.index < 0) {
  //       this.index = this.allList.length - 1
  //     }
  //     console.log(this.index)
  //   },
  //   next() {
  //     this.index++
  //     if (this.index >= this.allList.length) {
  //       this.index = 0
  //     }
  //   },
  //   prev() {
  //     this.index--
  //     if (this.index < 0) {
  //       this.index = this.allList.length - 1
  //     }
  //   },
  //   eventKeyDown(event) {
  //     if (event.code === 'ArrowLeft') {
  //       this.prev()
  //     }
  //     if (event.code === 'ArrowRight') {
  //       this.next()
  //     }
  //     return true
  //   },
  //   toGallery(index) {
  //     console.log(index)
  //     this.index = index
  //     // this.index = this.allList.findIndex(item => item.id === index)
  //   },
  //   getInfo() {
  //     getGalleryInfo(this.galleryId)
  //       .then(res => {
  //         // this.gallery = res.data
  //         // this.setTitlePage(this.gallery.name)
  //       })
  //   },
  //   setTitlePage(val) {
  //     document.title = val
  //     pageTitle.value = val
  //   },
  //   createRow() {
  //     let ar = []
  //     let w = 0
  //     this.showList = []
  //
  //     Object.values(this.allList).forEach(item => {
  //       const tw = this.heightImage * item.ratio
  //       if ((w + tw) > (this.width - 35)) {
  //         const hn = this.heightImage * (this.width - 20) / w
  //         this.showList.push(
  //           {
  //             h: hn,
  //             items: ar
  //           }
  //         )
  //         ar = []
  //         w = 0
  //       }
  //       w = w + this.heightImage * item.ratio
  //       ar.push(item)
  //     })
  //     if (ar.length > 0) {
  //       const hn = this.heightImage * (this.width - 20) / w
  //       this.showList.push(
  //         {
  //           h: hn,
  //           items: ar
  //         }
  //       )
  //     }
  //   },
  //   reloadData() {
  //     this.listQuery.page = 1
  //     this.allList = []
  //     this.total = 0
  //     this.getData()
  //   },
  //   getData() {
  //     console.log('close')
  //     if (this.total === 0 || this.allList.length < this.total) {
  //       getImageListForGallery(this.listQuery)
  //         .then(res => {
  //           // this.total = res.data.total
  //           // this.setTitlePage(this.gallery.name + ' (' + res.data.length + ')')
  //           res.data.forEach(item => {
  //             this.allList[item.id] = item
  //           })
  //           this.createRow()
  //         })
  //     }
  //   }
  // }
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
