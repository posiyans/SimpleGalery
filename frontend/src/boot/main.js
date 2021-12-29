export default ({ app, router, store, Vue }) => {
  const whiteList = ['/auth/login', '/auth/redirect'] // no redirect whitelist
  router.beforeEach(async (to, from, next) => {
    console.log('to')
    console.log(to.path)
    console.log('from')
    console.log(from.path)
    const user = store.state.user.info
    console.log('user')
    console.log(user)
    if (user) {
      if (user.role === 'guest') {
        if (whiteList.indexOf(to.path) !== -1) {
          // in the free login whitelist, go directly
          next()
        } else {
          next(`/auth/login?redirect=${to.path}`)
        }
      } else {
        if (to.path === '/auth/login') {
          next({ path: '/' })
        } else {
          next()
        }
      }
    } else {
      const { role } = await store.dispatch('user/getInfo')
      if (role === 'guest') {
        next(`/auth/login?redirect=${to.path}`)
      } else {
        next({ ...to, replace: true })
      }
      // try {
      //   const r = await store.dispatch('user/getInfo')
      //   console.log('r')
      //   console.log(r)
      //   next({ ...to, replace: true })
      // } catch (error) {
      //   // remove token and go to login page to re-login
      //   // await store.dispatch('user/resetToken')
      //   console.log(error)
      //   // next(`/login?redirect=${to.path}`)
      // }
    }
  })
}
