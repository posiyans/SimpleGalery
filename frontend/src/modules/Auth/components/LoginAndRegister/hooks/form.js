import { computed, ref } from 'vue'

const registration = ref(false)

const title = computed(() => {
  if (registration.value) {
    return 'Новый пользователь'
  }
  return 'Авторизация'
})

const btnLabel = computed(() => {
  if (registration.value) {
    return 'Регистрация'
  }
  return 'Вход'
})

const switchTypeForm = function() {
  registration.value = !registration.value
}

export {
  registration,
  title,
  btnLabel,
  switchTypeForm
}
