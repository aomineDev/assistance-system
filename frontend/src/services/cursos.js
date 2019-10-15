import { service } from './service'

const cursosService = {
  getCursosByEstudiante: id => {
    return service.get(`/cursos/estudiante/${id}`)
  },
  getCursosByDocente: id => {
    return service.get(`/cursos/docente/${id}`)
  }
}

export default cursosService
