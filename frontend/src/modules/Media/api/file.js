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

export function getImageListForGallery(query) {
  return request({
    url: '/api/v1/medial/gallery/get-image-list',
    method: 'get',
    params: query
  })
}

export function getGalleryInfo(id) {
  return request({
    url: '/api/v1/medial/folders/resource/' + id,
    method: 'get'
  })
}

export function addFolderInList(data) {
  return request({
    url: '/api/v1/medial/folders/resource',
    method: 'post',
    data: data
  })
}

export function deleteFolderInList(id) {
  return request({
    url: '/api/v1/medial/folders/resource/' + id,
    method: 'delete'
  })
}
export function fetchFolderTree(query) {
  return request({
    url: '/api/v1/medial/folders/get-tree',
    method: 'get',
    params: query
  })
}

export function getGalleryImage(query) {
  return request({
    url: '/api/v1/medial/folders/get-gallery-image',
    method: 'get',
    responseType: 'blob',
    params: query
  })
}

export function getImageModel(query) {
  return request({
    url: '/api/v1/medial/gallery/get-image-info',
    method: 'get',
    params: query
  })
}
// export function uploadImage(data) {
//   return request({
//     url: '/api/v1/medial/folders/upload-image-in-gallery',
//     method: 'post',
//     data: data
//   })
// }
