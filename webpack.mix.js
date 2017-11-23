let mix = require('laravel-mix')

mix.js('resources/assets/js/site.js', 'public/js')
  .sass('resources/assets/sass/site.scss', 'public/css')
  .copy('resources/assets/lib/icomoon_site/fonts/', 'public/css/fonts')
  .options({ processCssUrls: false })
  .copy('resources/assets/img', 'public/img')

mix
  .js('resources/assets/js/app.js', 'public/app_assets/js/app.js')
  .sass('resources/assets/sass/app.scss', 'public/app_assets/css/app.css')
  .copy('resources/assets/lib/icomoon/fonts/', 'public/app_assets/css/fonts')
  .options({ processCssUrls: false })

mix.version()

if (mix.config.inProduction) {
}
