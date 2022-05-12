import request from 'src/utils/request'

export function getGalleryTree(params) {
  return request({
    url: '/api/v1/medial/gallery/get-tree',
    method: 'get',
    params
  })
}

export function updateGalleryModel(data) {
  return request({
    url: '/api/v1/medial/gallery/update/' + data.id,
    method: 'post',
    data
  })
}

export function createGalleryModel(data) {
  return request({
    url: '/api/v1/medial/gallery/create/',
    method: 'post',
    data
  })
}
