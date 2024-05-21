const routes = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', name: 'LoginPage', component: () => import('pages/LoginPage.vue') },
      { path: '/register', name: 'RegisterPage', component: () => import('pages/RegisterPage.vue') },
      { path: '/product', name: 'ProductPage', component: () => import('pages/ProductPage.vue') },
      { path: '/productdetail/:id', name: 'ProductDetailPage', component: () => import('pages/ProductDetailPage.vue') },
      { path: '/cart', name: 'CartPage', component: () => import('pages/CartPage.vue') },
      { path: '/checkout', name: 'CheckoutPage', component: () => import('pages/CheckoutPage.vue') },
      { path: '/submitcheckout', name: 'SubmitCheckoutPage', component: () => import('pages/SubmitCheckoutPage.vue') },
      { path: '/confirmpayment', name: 'ConfirmPaymentPage', component: () => import('pages/ConfirmPaymentPage.vue') }

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
