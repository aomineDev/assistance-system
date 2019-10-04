import service from './service'

const asistenciasService = {
  getAsitencia: id => {
    return service.get(`/asistencia/${id}`)
  }
}

export default asistenciasService
