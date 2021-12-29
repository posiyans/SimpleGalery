
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
      { path: '', component: () => import('pages/Index.vue') }
    ]
  },
  {
    path: '/auth',
    component: () => import('layouts/ClearLayout.vue'),
    children: [
      { path: 'login', component: () => import('pages/Auth/Login/index.vue') }
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
      { path: 'media/folders', component: () => import('src/modules/Media/pages/Folder/index.vue') }
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
