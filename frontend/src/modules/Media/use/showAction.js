import { index, gallery, showMedia } from 'src/modules/Media/use/useGallery'
import { getGalleryImage, getImageModel } from 'src/modules/Media/api/file'
import { exportFile } from 'quasar'
import { ref } from 'vue'
import { isObject } from 'lodash'

const play = ref(false)

const next = () => {
  if (isObject(index.value)) {
    index.value = 0
  }
  index.value++
  checkIndex()
}
const prev = () => {
  if (isObject(index.value)) {
    index.value = 0
  }
  index.value--
  checkIndex()
}

const checkIndex = () => {
  if (index.value > gallery.value.length - 1) {
    index.value = 1
  } else if (index.value < 1) {
    index.value = gallery.value.length - 1
  }
}

const setIndex = (id) => {
  index.value = gallery.value.findIndex(item => item.id === id)
  checkIndex()
}

const closeShowMedia = () => {
  index.value = null
}

const setIndexModel = (id) => {
  getImageModel({ id: id })
    .then(res => {
      index.value = res.data
    })
}

const downloadShowMedia = () => {
  getGalleryImage({ id: showMedia.value.id })
    .then(res => {
      exportFile(showMedia.value.name, res.data)
    })
}

export {
  prev,
  next,
  play,
  setIndexModel,
  setIndex,
  closeShowMedia,
  downloadShowMedia
}
