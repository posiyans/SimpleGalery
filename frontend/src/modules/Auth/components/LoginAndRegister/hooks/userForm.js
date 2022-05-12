import { registration } from 'src/modules/Auth/components/LoginAndRegister/hooks/form'
import { reactive, ref } from 'vue'
import { useQuasar } from 'quasar'

export function userForm(store, router) {
  const $q = useQuasar()
  const loading = ref(false)
  const regEnable = ref(false)
  const user = reactive(
    {
      email: '',
      name: '',
      password: '',
      password_confirmation: ''
    }
  )

  function diffPassword(val) {
    return ((val && val === user.password) || 'Пароли не совпадают!')
  }

  const submit = () => {
    if (registration.value) {
      userRegistration()
    } else {
      userLogin()
    }
  }
  const checkRegToken = async (token) => {
    regEnable.value = false
    registration.value = false
    try {
      await store.dispatch('user/checkToken', token)
      user.token = token
      regEnable.value = true
    } catch (e) {
    }
  }

  const userLogin = async () => {
    const data = {
      email: user.email,
      password: user.password,
      remember: true
    }
    loading.value = true
    try {
      await store.dispatch('user/login', data)
      router.push('/')
    } catch (e) {
      $q.dialog({
        title: 'Ошибка',
        message: e.response.data.message
      }).onOk(() => {
      })
    }
    loading.value = false
  }

  const userRegistration = async () => {
    try {
      loading.value = true
      const data = Object.assign({}, user)
      await store.dispatch('user/register', data)
      registration.value = false
      user.email = ''
      user.name = ''
      user.password = ''
      user.password_confirmation = ''
      $q.dialog({
        title: 'Успех',
        message: 'Вы успешно прошли регистрацию'
      })
    } catch (e) {
      $q.dialog({
        title: 'Ошибка',
        message: e.response.data.message
      }).onOk(() => {
      })
    }
    loading.value = false
  }

  return { submit, user, diffPassword, loading, checkRegToken, regEnable }
}
