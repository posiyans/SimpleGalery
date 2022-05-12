import { computed, ref } from 'vue'

const activeGallery = ref({})
const galleryTitle = computed(() => {
  if (activeGallery.value.name) {
    return activeGallery.value.name
  }
  return ''
})
export { activeGallery, galleryTitle }
