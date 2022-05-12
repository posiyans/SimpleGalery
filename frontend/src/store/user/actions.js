import { userLogin, myInfo, userRegister, userLogout, checkRegToken } from 'src/store/user/api/auth'
import { LocalStorage } from 'quasar'
import { getCsrfCookie } from 'src/modules/Auth/api/token'

export function getInfo({ commit }) {
  return new Promise((resolve, reject) => {
    myInfo().then(res => {
      commit('setInfo', res.data)
      resolve(res.data)
    }).catch(() => {
      resolve({ role: 'guest' })
      // reject(error)
    })
  })
}

export function register(state, data) {
  return new Promise((resolve, reject) => {
    getCsrfCookie()
      .then(() => {
        userRegister(data)
          .then(res => {
            // state.commit('setInfo', res.data)
            resolve()
          }).catch(error => {
            reject(error)
          })
      })
  })
}

export function checkToken(state, token) {
  return new Promise((resolve, reject) => {
    getCsrfCookie()
      .then(() => {
        checkRegToken({ token })
          .then(res => {
            if (res.data) {
              resolve()
            } else {
              reject()
            }
          }).catch(() => {
            reject()
          })
      })
  })
}
export function login(state, data) {
  return new Promise((resolve, reject) => {
    getCsrfCookie()
      .then(() => {
        userLogin(data)
          .then(res => {
            if (res.data.token) {
              LocalStorage.set('user_token', res.data.token)
              state.dispatch('getInfo')
                .then(() => {
                  resolve()
                })
            }
          }).catch(error => {
            reject(error)
          })
      })
  })
}

export function logout(state, data) {
  return new Promise((resolve, reject) => {
    userLogout(data)
      .then(async () => {
        await state.dispatch('resetToken')
        resolve()
      }).catch(error => {
        reject(error)
      })
  })
}

export function resetToken(state) {
  return new Promise((resolve) => {
    LocalStorage.remove('user_token')
    state.commit('setInfo', { role: 'guest' })
    resolve()
  })
}
