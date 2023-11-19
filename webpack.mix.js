let mix = require('laravel-mix');

mix.js('resources/js/reactjs/app.js', 'public/js/reactjs')
    .react();

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
