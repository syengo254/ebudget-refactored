import { mount } from '@vue/test-utils'
import HomePage from '@/pages/home/HomePage.vue'
import { createTestingPinia } from '@pinia/testing'

test('it has the correct title', async () => {
  const pinia = createTestingPinia()
  const wrapper = mount(HomePage, {
    global: {
      plugins: [pinia],
    },
  })

  // wait for the page to load
  await wrapper.vm.$nextTick()

  // check if the page has the correct title
  expect(wrapper.html()).toContain('Home')
})
