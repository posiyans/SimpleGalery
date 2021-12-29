import { userLogin, myInfo, userRegister, userLogout } from 'src/store/user/api/auth'

export function getInfo({ commit }) {
  return new Promise((resolve, reject) => {
    myInfo().then(res => {
      commit('setInfo', res.data)
      resolve(res.data)
    }).catch(error => {
      reject(error)
    })
  })
}

export function register(state, data) {
  return new Promise((resolve, reject) => {
    userRegister(data)
      .then(res => {
        state.commit('setInfo', res.data)
      }).catch(error => {
        reject(error)
      })
  })
}

export function login(state, data) {
  return new Promise((resolve, reject) => {
    userLogin(data)
      .then(res => {
        state.commit('setInfo', res.data)
        resolve()
      }).catch(error => {
        reject(error)
      })
  })
}

export function logout(state, data) {
  return new Promise((resolve, reject) => {
    userLogout(data)
      .then(res => {
        state.commit('setInfo', { role: 'guest' })
        resolve()
      }).catch(error => {
        reject(error)
      })
  })
}
