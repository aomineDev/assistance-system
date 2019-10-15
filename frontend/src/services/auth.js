import { auth, authWithToken } from './service'

const authService = {
  login: credentials => {
    return auth.post(`/login`, credentials)
  },
  logout: () => {
    return authWithToken.get('/logout')
  }
}

export default authService
