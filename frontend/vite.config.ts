import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'

import path from 'path'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue(), vueDevTools()],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src'), // Configure the @ alias
    },
  },
  preview: {
    port: 5173,
  },
})
