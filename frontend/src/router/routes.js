
const routes = [
  {
    path: '/redirect',
    component: () => import('layouts/ClearLayout.vue'),
    hidden: true,
    children: [
      {
        path: '/redirect/:path(.*)',
        component: () => import('pages/redirect/index')
      }
    ]
  },
  {
    path: '/',
    component: () => import('layouts/UserLayout.vue'),
    children: [
      { path: '', component: () => import('src/modules/Media/pages/GalleryList/index.vue') }
    ]
  },
  {
    path: '/auth',
    component: () => import('layouts/ClearLayout.vue'),
    children: [
      { path: 'login', component: () => import('src/modules/Auth/pages/Login/index.vue') },
      { path: 'login-by-token', component: () => import('src/modules/Auth/pages/LoginBуToken/index.vue') }
    ]
  },
  {
    path: '/gallery-list',
    component: () => import('layouts/UserLayout.vue'),
    children: [
      { path: '', component: () => import('src/modules/Media/pages/GalleryList/index.vue') }
    ]
  },
  {
    path: '/gallery/:id',
    component: () => import('layouts/UserLayout.vue'),
    children: [
      { path: '', component: () => import('src/modules/Media/pages/GalleryShow/index.vue') }
    ]
  },
  {
    path: '/media',
    component: () => import('layouts/UserLayout.vue'),
    children: [
      { path: '', component: () => import('src/modules/Media/pages/MediaList/index.vue') }
    ]
  },
  {
    path: '/settings',
    component: () => import('layouts/UserLayout.vue'),
    children: [
      { path: 'media/folders', component: () => import('src/modules/Media/pages/Folder/index.vue') },
      { path: 'help', component: () => import('src/modules/Help/pages/UserToken/index.vue') },
      { path: 'gallery', component: () => import('src/modules/Gallery/pages/GallerySetting/index.vue') }
    ]
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/Error404.vue')
  }
]

export default routes
