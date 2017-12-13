require('vue2-animate/dist/vue2-animate.min.css')

window._ = require('lodash');

window.uniqid = require('uniqid');

window.moment = require('moment');
import 'moment/locale/es';


window.$ = window.jQuery = require('jquery');

// window.Tether = require('tether')

// ES6 Modules or TypeScript
import swal from 'sweetalert2'
swal.setDefaults({
    buttonsStyling: false,
    confirmButtonText: 'Ok',
    cancelButtonText: 'Cancelar',
    confirmButtonClass: 'btn btn-lg btn-primary',
    cancelButtonClass: 'btn btn-lg btn-secondary',
    inputClass: 'form-control',
    padding: 30
});

window.swal = swal;

window.Vue = require('vue');

window.Velocity = require('velocity-animate');

import axios from 'axios';
import axiosCancel from 'axios-cancel';
axiosCancel(axios, {
  debug: false // default
});
window.axios = axios

window.format = require('string-template');

window.select2 = require('select2');
$.fn.select2.defaults.set('language', 'es');

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': App.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'cd7cbb4ba8beea72c553',
});
