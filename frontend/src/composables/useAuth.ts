import axios from '../utils/axios.ts'

function useAuth() {
  async function logout() {
    const response = await axios.post('/logout')

    if (response.status == 200) {
      return response.data.success
    }
  }

  return {
    logout,
  }
}

export default useAuth
