import { ref } from 'vue'
// import { getGalleryTree } from 'src/modules/Gallery/api/galleryApi'
import { createGalleryModel, updateGalleryModel } from 'src/modules/Gallery/api/galleryApi'
import { Notify } from 'quasar'

const gallery = ref({})
const typeAccess = [
  {
    value: 'private',
    label: 'Личный'
  },
  {
    value: 'public',
    label: 'Публичный'
  }
]
const galleries = ref([
  {
    id: '',
    level: 0,
    name: 'Без родителя'
  }
])
const updateGallery = () => {
  if (gallery.value.id) {
    updateGalleryModel(gallery.value)
      .then(res => {
        Notify.create({
          type: 'positive',
          color: 'positive',
          timeout: 500,
          position: 'top-right',
          message: 'res.data'
        })
      })
  } else {
    createGalleryModel(gallery.value)
      .then(res => {
        Notify.create({
          type: 'positive',
          color: 'positive',
          timeout: 500,
          position: 'top-right',
          message: 'res.data'
        })
      })
  }
}
// onMounted(() => {
//   console.log('mounted!!!')
//   getGalleryTree()
//     .then(res => {
//       galleries.value = []
//       galleries.value.push({
//         id: '',
//         level: 0,
//         path: '',
//         name: 'Без родителя'
//       })
//       res.data.forEach(item => {
//         galleries.value.push({
//           id: item.id,
//           name: item.name,
//           path: item.path,
//           level: 1
//         })
//       })
//     })
// })

export {
  updateGallery,
  galleries,
  gallery,
  typeAccess
}
