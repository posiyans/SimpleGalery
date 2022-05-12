import { userModel } from 'src/hooks/userModel/userModel'
export default ({ app, router, store, Vue }) => {
  userModel(store, router)
  const whiteList = ['/auth/login', '/auth/login-by-token', '/auth/redirect'] // no redirect whitelist
  router.beforeEach(async (to, from, next) => {
    let user = store.state.user.info
    if (!user) {
      try {
        user = await store.dispatch('user/getInfo')
      } catch (error) {
        const code = error.response.status
        if (code === 401 || code === 419) {
          await store.dispatch('user/resetToken')
          store.commit('user/setInfo', { role: 'guest' })
          next('/auth/login')
        }
      }
    }
    if (user.role === 'guest') {
      if (whiteList.indexOf(to.path) !== -1) {
        next()
      } else {
        next('/auth/login')
      }
    } else {
      if (whiteList.indexOf(to.path) === -1) {
        next()
      } else {
        next({ path: '/' })
      }
    }
  })
}
