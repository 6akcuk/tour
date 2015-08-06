<?php

namespace App\Helpers\Backpack;

use Illuminate\Support\ServiceProvider;

class BackpackServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('bhtml', function($app)
        {
            return new BHtmlBuilder();
        });

        $this->app->alias('bhtml', 'App\Helpers\Backpack\BHtmlBuilder');
    }
}