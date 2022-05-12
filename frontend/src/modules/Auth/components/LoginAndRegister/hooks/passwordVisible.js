import { computed, ref } from 'vue'

const visibility = ref(false)

const passwordFieldType = computed(() => {
  if (visibility.value) {
    return 'text'
  }
  return 'password'
})

const visibilityIcon = computed(() => {
  if (visibility.value) {
    return 'visibility_off'
  }
  return 'visibility'
})

function switchVisibility() {
  visibility.value = !visibility.value
}
export {
  passwordFieldType,
  visibilityIcon,
  switchVisibility
}
