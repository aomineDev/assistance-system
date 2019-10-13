import { auth } from './service'

const authService = {
  login: credentials => {
    return auth.post(`/login`, credentials)
  }
}

export default authService
