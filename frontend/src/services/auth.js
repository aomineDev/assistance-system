import service from './service'

const authService = {
  login: id => {
    return service.get(`/user/${id}`)
  }
}

export default authService
