import request from 'src/utils/request'

export function getCsrfCookie() {
  return request({
    url: '/api/v1/csrf-cookie',
    method: 'get'
  })
}
