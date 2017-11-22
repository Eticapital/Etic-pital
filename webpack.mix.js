let mix = require('laravel-mix');

mix.js('resources/assets/js/site.js', 'public/js')
   .sass('resources/assets/sass/site.scss', 'public/css')

mix.copy('resources/assets/img', 'public/img')

mix
    .js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')

mix.version();

if (mix.config.inProduction) {
}
