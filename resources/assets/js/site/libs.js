// require videojs style [and custom videojs theme]
require('video.js/dist/video-js.css')
require('vue-video-player/src/custom-theme.css')

// Componentes de Bootstrap para VUe
import BootstrapVue from 'bootstrap-vue/dist/bootstrap-vue.esm';
Vue.use(BootstrapVue);

// Previsualizar imagenes
import Croppa from 'vue-croppa'
Vue.use(Croppa)

import VueVideoPlayer from 'vue-video-player'
Vue.use(VueVideoPlayer)

require('videojs-youtube')
require('videojs-vimeo')
