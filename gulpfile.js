var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    //mix.sass('app.scss');
    mix.styles([
        'bootstrap.css',
        'animate.min.css',
        'style.css',
        'menu.css',
        'responsive.css',
        'fontello/css/icon_set_1.css',
        'fontello/css/icon_set_2.css',
        'fontello/css/fontello.css',
        'magnific-popup.css',

        'color-backpack.css',
        'skins/square/grey.css',
        'date_time_picker.css',
        'blog.css',
        'backpack.css'
    ], 'public/css/all.css', 'public/css');
});
