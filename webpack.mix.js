const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/custom.js', 'public/assets/js')
  .js('resources/js/app.js', 'public/assets/js')
  .js('resources/js/format_number/simple.format.number.js', 'public/assets/vendor/format_number')
  .css('resources/css/filepond/filepond.css', 'public/assets/css')
  .css('resources/css/vendor.css', 'public/assets/css')
  .sass('resources/sass/app.sass', 'public/assets/css');

    mix.webpackConfig({
        output: {
          library: 'shopdat09',
          libraryTarget: 'umd',
          umdNamedDefine: true, // optional
          globalObject: 'this' // optional
        }
      })