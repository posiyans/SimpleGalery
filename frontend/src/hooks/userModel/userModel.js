import { computed } from 'vue'
let _store = null
let _router = null

const user = computed(() => {
  return _store.state.user.info
})

const userName = computed(() => {
  return user.value.name
})

export function userModel(store, router) {
  _store = store
  _router = router
  return ''
}

const logout = async function() {
  try {
    await _store.dispatch('user/logout')
    _router.push('/auth/login')
  } catch (error) {
    console.log(error)
  }
}
export { logout, userName, user }
