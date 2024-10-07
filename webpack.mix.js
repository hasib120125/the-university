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

const NodePolyfillPlugin = require("node-polyfill-webpack-plugin") 

mix.webpackConfig({
        plugins: [
            new NodePolyfillPlugin(),
        ],
    })

mix.js('resources/js/front/app.js', 'public/js')
    .js('resources/js/admin/app.js', 'public/js/admin.js')
    .js('resources/js/front/app.js', 'public/js/front.js')
    .js('resources/js/student/app.js', 'public/js/student.js')
    .js('resources/js/professor/app.js', 'public/js/professor.js').vue()
    .sass('public/themes/admin/scss/main.scss', 'public/themes/admin/css')
    .sass('public/themes/student/scss/main.scss', 'public/themes/student/css')
    .sass('public/themes/front/scss/main.scss', 'public/themes/front/css')
    .options({ autoprefixer: false });

if (mix.inProduction()) {
    mix.version();
}
