const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', name: 'LoginPage', component: () => import('pages/LoginPage.vue') },
      { path: 'home', name: 'HomePage', component: () => import('pages/HomePage.vue') },
      { path: 'product', name: 'ProductPage', component: () => import('pages/ProductPage.vue') },
      { path: 'order', name: 'OrderPage', component: () => import('pages/OrderPage.vue') },
      { path: 'insertproduct', name: 'InsertProductPage', component: () => import('pages/InsertPage.vue') },
      { path: 'insertorder', name: 'InsertOrderPage', component: () => import('pages/InsertOrderPage.vue') },
      { path: 'update/:id', name: 'UpdatePage', component: () => import('pages/UpdatePage.vue') },
      { path: 'image/:id', name: 'ImagePage', component: () => import('pages/ImagePage.vue') },
      { path: 'image/:id/insert', name: 'InsertImagePage', component: () => import('pages/InsertImagePage.vue') }
    ]
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
