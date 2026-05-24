import http from './http'

export default {
  getAll: () => http.get('/autores').then(response => response.data.data),
  getById: (id) => http.get(`/autores/${id}`).then(response => response.data.data),
  create: (payload) => http.post('/autores', payload).then(response => response.data.data),
  update: (id, data) => http.put(`/autores/${id}`, data).then(response => response.data.data),
  remove: (id) => http.delete(`/autores/${id}`),
}
