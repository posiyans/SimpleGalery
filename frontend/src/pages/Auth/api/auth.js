import request from 'src/utils/request'

export function userLogin(data) {
  return request({
    url: '/api/v1/auth/login',
    method: 'post',
    data: data
  })
}
