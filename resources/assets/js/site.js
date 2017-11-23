require('./site/bootstrap.js')

// Crud Formsº
require('./forms/bootstrap')
require('./forms/inputs')

// Custom Vue Components
require('./site/libs.js')
require('./site/components.js')

const app = new Vue({
  el: '#app'
})
