import axios from 'axios'

import { LocalStorage } from 'quasar'

// create an axios instance
const service = axios.create({
  baseURL: process.env.BASE_API, // url = base url + request url
  withCredentials: true, // send cookies when cross-domain requests
  timeout: 25000 // request timeout
})
// request interceptor
service.interceptors.request.use(
  config => {
    const token = LocalStorage.getItem('user_token')
    config.headers.Authorization = 'Bearer ' + token
    // api.defaults.headers.post['Content-Type'] = 'application/json';
    return config
  },
  error => {
    // do something with request error
    return Promise.reject(error)
  }
)

// response interceptor
service.interceptors.response.use(
  /**
   * If you want to get http information such as headers or status
   * Please return  response => response
   */

  /**
   * Determine the request status by custom code
   * Here is just an example
   * You can also judge the status by HTTP Status Code
   */
  response => {
    const res = response
    return res
  },
  error => {
    return Promise.reject(error)
  }
)

export default service
