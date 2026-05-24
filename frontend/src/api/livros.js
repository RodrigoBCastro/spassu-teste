import http from './http'

export default {
  getAll: (page = 1) => http.get('/livros', { params: { page } }).then(response => response.data),
  getById: (id) => http.get(`/livros/${id}`).then(response => response.data.data),
  create: (payload) => http.post('/livros', payload).then(response => response.data.data),
  update: (id, data) => http.put(`/livros/${id}`, data).then(response => response.data.data),
  remove: (id) => http.delete(`/livros/${id}`),
}
