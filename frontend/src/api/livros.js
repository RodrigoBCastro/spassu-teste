import http from './http'

export default {
  getPaginado: (page = 1, perPage = 15) => http.get('/livros', { params: { page, per_page: perPage } }).then(response => response.data),
  getTodos: () => http.get('/livros/todos').then(response => response.data.data),
  getById: (id) => http.get(`/livros/${id}`).then(response => response.data.data),
  create: (payload) => http.post('/livros', payload).then(response => response.data.data),
  update: (id, data) => http.put(`/livros/${id}`, data).then(response => response.data.data),
  remove: (id) => http.delete(`/livros/${id}`),
}
