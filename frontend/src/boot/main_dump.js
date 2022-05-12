// import { getCsrfCookie } from 'src/modules/Auth/api/token'
import { userModel } from 'src/hooks/userModel/userModel'
export default ({ app, router, store, Vue }) => {
  userModel(store, router)
  const whiteList = ['/auth/login', '/auth/login-by-token', '/auth/redirect'] // no redirect whitelist
  router.beforeEach(async (to, from, next) => {
    if (whiteList.indexOf(to.path) !== -1) {
      next()
    }
    const user = store.state.user.info
    if (user) {

      if (user.role === 'guest') {
        if (whiteList.indexOf(to.path) !== -1) {
          next()
        } else {
          // next(`/auth/login?redirect=${to.path}`)
          console.log(to)
          next('/auth/login')
        }
      } else {
        if (to.path === '/auth/login') {
          next({ path: '/' })
        } else {
          // getCsrfCookie()
          next()
        }
      }
    } else {
      try {
        const { role } = await store.dispatch('user/getInfo')
        if (role === 'guest') {
          // next(`/auth/login?redirect=${to.path}`)
          console.log(to)
          next('/auth/login')
        } else {
          // userModel(store, router)
          next({ ...to, replace: true })
        }
      } catch (error) {
        const code = error.response.status
        if (code === 401 || code === 419) {
          // await store.dispatch('user/resetToken')
          // next(`/auth/login?redirect=${to.path}`)
          console.log(to.query)
          if (to.query && to.query.token) {
            next(`/auth/login-by-token?token=${to.query.token}`)
          } else {
            next('/auth/login')
          }
        }
      }
    }
  })
}
