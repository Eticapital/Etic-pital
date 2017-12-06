window._ = require('lodash')

window.uniqid = require('uniqid')

const swal = require('sweetalert2')
swal.setDefaults({
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: false,
  cancelButtonText: 'Cancelar'
})
window.swal = swal

try {
  window.$ = window.jQuery = require('jquery')

  // require('bootstrap-sass');
} catch (e) {}

import axios from 'axios'
import axiosCancel from 'axios-cancel'
axiosCancel(axios, {
  debug: false // default
})
window.axios = axios

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

window.Vue = require('vue')
