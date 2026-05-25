import http from './http'

export default {
  getPaginado: (page = 1, perPage = 15) => http.get('/assuntos', { params: { page, per_page: perPage } }).then(response => response.data),
  getTodos: () => http.get('/assuntos/todos').then(response => response.data.data),
  getById: (id) => http.get(`/assuntos/${id}`).then(response => response.data.data),
  create: (payload) => http.post('/assuntos', payload).then(response => response.data.data),
  update: (id, data) => http.put(`/assuntos/${id}`, data).then(response => response.data.data),
  remove: (id) => http.delete(`/assuntos/${id}`),
}
