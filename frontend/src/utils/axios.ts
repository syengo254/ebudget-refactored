import axios from 'axios'

const apiUrl = import.meta.env.VITE_API_URL

const instance = axios.create({
  baseURL: apiUrl,
  timeout: 1000,
  headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
  withCredentials: true,
  withXSRFToken: true,
})

export default instance
