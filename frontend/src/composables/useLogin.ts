import axios from '../utils/axios.ts'

export default function useLogin() {
  async function login(credentials: { email: string; password: string }) {
    await axios.get(import.meta.env.VITE_BASE_URL + 'sanctum/csrf-cookie')
    const response = await axios.post('/login', credentials)
    return response
  }

  return login
}
