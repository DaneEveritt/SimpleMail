let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 */

mix.postCss('resources/assets/css/main.css', 'public/css', [
    tailwindcss('./tailwind.js'),
]);

mix.js('resources/assets/js/app.js', 'public/js');
