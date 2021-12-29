import request from 'src/utils/request'

export function fetchFileList(query) {
  return request({
    url: '/api/v1/medial/files/get-list',
    method: 'get',
    params: query
  })
}

export function fetchFolderList(query) {
  return request({
    url: '/api/v1/medial/folders/resource',
    method: 'get',
    params: query
  })
}

export function addFolderInList(data) {
  return request({
    url: '/api/v1/medial/folders/resource',
    method: 'post',
    data: data
  })
}

export function fetchFolderTree(query) {
  return request({
    url: '/api/v1/medial/folders/get-tree',
    method: 'get',
    params: query
  })
}
