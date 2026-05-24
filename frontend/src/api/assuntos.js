import http from './http'

export default {
  getAll: () => http.get('/assuntos').then(response => response.data.data),
  getById: (id) => http.get(`/assuntos/${id}`).then(response => response.data.data),
  create: (payload) => http.post('/assuntos', payload).then(response => response.data.data),
  update: (id, data) => http.put(`/assuntos/${id}`, data).then(response => response.data.data),
  remove: (id) => http.delete(`/assuntos/${id}`),
}
