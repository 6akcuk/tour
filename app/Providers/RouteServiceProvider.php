<?php

namespace App\Providers;

use App\BlogCategory;
use App\Page;
use App\Post;
use App\Tag;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //
        $router->bind('slug', function($slug) {
            return Post::where('slug', '=', $slug)->first();
        });
        $router->bind('category_name', function($value) {
            return BlogCategory::where('name', '=', $value)->first();
        });
        $router->bind('tag_name', function($value) {
            return Tag::where('tag', '=', $value)->first();
        });
        $router->bind('page', function($page) {
            return Page::where('slug', $page)->first();
        });

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
