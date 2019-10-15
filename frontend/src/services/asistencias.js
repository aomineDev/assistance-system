import { service } from './service'

const asistenciasService = {
  getCursos: id => {
    return service.get(`/cursos/${id}`)
  },
  getAsistencias: (cursoId, docenteId) => {
    return service.get(`/asistencias/curso/${cursoId}/${docenteId}`)
  },
  getPorcentajes: (cursoId, docenteId) => {
    return service.get(`/asistencias/estudiante/${cursoId}/${docenteId}`)
  },
  getAsitencia: id => {
    return service.get(`/asistencia/${id}`)
  },
  updateDetails: details => {
    return service.put('/details/update', {
      'id': details.id,
      'aula': details.aula,
      'tema': details.tema,
      'software': details.software,
      'avance': details.avance,
      'fecha': details.fecha,
      'proyector': details.proyector
    })
  },
  updateAsistencias: (firmas, id) => {
    return service.put(`/firmas/update/${id}`, firmas)
  },
  enabledToggle: (value, id) => {
    return service.put(`/details/habilitar/${id}`, {
      habilitado: value
    })
  },
  updateAsistencia: (firma, id) => {
    return service.put(`/firma/update/${id}`, {
      firma
    })
  }
}

export default asistenciasService
