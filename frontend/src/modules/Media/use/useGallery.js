import { ref, computed } from 'vue'
import { getImageListForGallery } from 'src/modules/Media/api/file'
import { isObject } from 'lodash'
// import { useQuasar } from 'quasar'

const gallery = ref([])
const rowList = ref([])
const index = ref(null)
const galleryId = ref()
let heightImage = 300
let width = 300
let page = 1
const limit = 20
// let $q = null
const getData = () => {
  getImageListForGallery({ id: galleryId.value })
    .then(res => {
      // избавляемся от нулевого индекса
      gallery.value = [{}, ...res.data]
      createRow()
    })
}

const onResize = () => {
  width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth
  // cost $q = useQuasar()
  // heightImage = $q.platform.is.mobile ? 150 : 300
  // heightImage = 150
  createRow()
}

const setHeightImage = (val) => {
  heightImage = val
}

const showMedia = computed(() => {
  if (isObject(index.value)) {
    return index.value
  }
  if (index.value && gallery.value[index.value]) {
    return gallery.value[index.value]
  }
  return false
})
const preloadMedia = computed(() => {
  const nextImg = index.value + 1
  if (gallery.value[nextImg]) {
    return gallery.value[nextImg]
  }
  return false
})
const loadMore = () => {
  page++
  createRow()
}

const createRow = () => {
  let ar = []
  let w = 0
  const rows = page * limit
  rowList.value = []
  // начинаем с 1 так нулевой заглушка
  gallery.value.slice(1, rows).forEach(item => {
    const tw = heightImage * item.ratio
    if ((w + tw) > (width - 35) && ar.length > 1) {
      const hn = heightImage * (width - 20) / w
      rowList.value.push(
        {
          h: hn,
          items: ar
        }
      )
      ar = []
      w = 0
    }
    w = w + heightImage * item.ratio
    ar.push(item)
  })
  if (ar.length > 0) {
    const hn = heightImage * (width - 20) / w
    rowList.value.push(
      {
        h: hn,
        items: ar
      }
    )
  }
  console.log(rowList.value)
}

export {
  preloadMedia,
  setHeightImage,
  loadMore,
  onResize,
  getData,
  galleryId,
  index,
  rowList,
  gallery,
  showMedia
}
