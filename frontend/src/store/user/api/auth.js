import request from 'src/utils/request'

export function userRegister(data) {
  return request({
    url: '/api/v1/auth/register',
    method: 'post',
    data: data
  })
}

export function userLogin(data) {
  return request({
    url: '/api/v1/auth/login',
    method: 'post',
    data: data
  })
}

export function checkRegToken(data) {
  return request({
    url: '/api/v1/auth/check-token',
    method: 'post',
    data: data
  })
}

export function myInfo() {
  return request({
    url: '/api/v1/auth/info',
    method: 'get'
  })
}

export function userLogout() {
  return request({
    url: '/api/v1/auth/logout',
    method: 'post'
  })
}
