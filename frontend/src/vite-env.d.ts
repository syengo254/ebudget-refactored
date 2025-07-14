/// <reference types="vite/client" />
declare module '*'

interface ImportMetaEnv {
  readonly VITE_API_URL: string
  readonly VITE_BASE_URL: string
  readonly VITE_APP_URL: string
  readonly VITE_APP_DOMAIN: string
}

interface ImportMeta {
  readonly env: ImportMetaEnv
}
