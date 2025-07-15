import HomePage from '../pages/home/HomePage.vue'
import { createTestingPinia } from '@pinia/testing'
import { mount } from '@vue/test-utils'
import ProductGroupView from '../components/products/ProductGroupView.vue'
import { useProductStore } from '../stores/productStore'

test('it has the correct title', async () => {
  const categories = ['keyboards', 'monitors']
  const pinia = createTestingPinia({
    stubActions: false,
  })
  const wrapper = mount(HomePage, {
    global: {
      plugins: [pinia],
    },
  })

  const productStore = useProductStore()
  await productStore.fetchCategories(true)

  expect(wrapper.findComponent(ProductGroupView).exists()).toBe(true)

  // check if the page has the correct title
  expect(wrapper.html()).toContain('home')
  expect(wrapper.html()).toContain(categories[0])
  expect(wrapper.html()).toContain(categories[1])
})
