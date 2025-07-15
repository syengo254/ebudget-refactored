import HomePage from '../pages/home/HomePage.vue'
import { createTestingPinia } from '@pinia/testing'
import { mount } from '@vue/test-utils'
// import ProductGroupView from '../components/products/ProductGroupView.vue'
import { ProductStoreType, useProductStore } from '../stores/productStore'
import { ProductType } from '../types'

test('it has the correct title', async () => {
  const categories = [
    {
      id: 1,
      name: 'Keyboards',
    },
    {
      id: 2,
      name: 'Monitors',
    },
  ]
  const products: ProductType[] = [
    {
      id: 1,
      name: 'This is a test product',
      price: 10,
      category_id: 1,
      category: {
        id: 1,
        name: 'Keyboards',
      },
      stock_amount: 10,
      image: 'http://',
      store_id: 2,
    },
    {
      id: 2,
      name: 'This is a test product',
      price: 10,
      category_id: 2,
      category: {
        id: 2,
        name: 'Monitors',
      },
      stock_amount: 10,
      image: 'http://',
      store_id: 2,
    },
  ]

  const initialState: ProductStoreType = {
    categories,
    products,
    cachedProducts: {},
    filters: {},
    loading: false,
    pagination: {},
    page: 1,
  }
  const pinia = createTestingPinia({
    initialState,
  })
  const wrapper = mount(HomePage, {
    global: {
      plugins: [pinia],
    },
  })

  const productStore = useProductStore()
  await productStore.fetchCategories(true)

  // expect(wrapper.findComponent(ProductGroupView).exists()).toBe(true)

  // check if the page has the correct title
  expect(wrapper.html()).toContain('home')
  // expect(wrapper.html()).toContain('keyboards')
  // expect(wrapper.html()).toContain(categories[1])
})
