import VendorPage from '../pages/vendor-pages/VendorPage.vue'
import DashboardPage from '../pages/vendor-pages/dashboard/DashboardPage.vue'
import VendorProductsPage from '../pages/vendor-pages/products/VendorProductsPage.vue'
import CreateProductPage from '../pages/vendor-pages/products/CreateProductPage.vue'

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
      path: 'catalog',
      name: 'catalog',
      component: VendorProductsPage,
      meta: {
        title: 'My Products | E-budget.com | Best Online Shoping Experience',
        guards: ['auth', 'store'],
      },
    },
    {
      path: 'add',
      name: 'add-product',
      component: CreateProductPage,
      meta: {
        title: 'Adding Products | E-budget.com | Best Online Shoping Experience',
        guards: ['auth', 'store'],
      },
    },
  ],
}
