import VendorPage from '../pages/vendor-pages/VendorPage.vue'
import DashboardPage from '../pages/vendor-pages/dashboard/DashboardPage.vue'
import VendorProductsPage from '../pages/vendor-pages/products/VendorProductsPage.vue'

export default {
  path: '/vendor',
  component: VendorPage,
  name: 'vendor',
  children: [
    {
      path: 'dashboard',
      name: 'dashboard',
      component: DashboardPage,
      meta: {
        title: 'Dashboard | E-budget.com | Best Online Shoping Experience',
        guards: ['auth', 'store'],
      },
    },
    {
      path: 'products',
      name: 'my-products',
      component: VendorProductsPage,
      meta: {
        title: 'My Products | E-budget.com | Best Online Shoping Experience',
        guards: ['store'],
      },
    },
  ],
}
