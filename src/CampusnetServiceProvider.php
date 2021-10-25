<?php

namespace Ajifatur\Campusnet;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\File;

class CampusnetServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any package services.
	 *
	 * @return void
	 */
	public function boot(Router $router)
	{
        // Use Bootstrap as paginator views
        Paginator::useBootstrap();
        
		// Add package's view
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'campusnet');

        // Add package's migration
        $this->loadMigrationsFrom(__DIR__.'/../migrations');

        // Add middlewares
        $router->aliasMiddleware('campusnet.user', \Ajifatur\Campusnet\Http\Middleware\UserMiddleware::class);
        $router->aliasMiddleware('campusnet.guest', \Ajifatur\Campusnet\Http\Middleware\GuestMiddleware::class);
	}

    /**
     * Register the application services.
     */
    public function register()
    {
        // Load helpers
        $this->loadHelpers();
	}

    /**
     * Load helpers.
     * 
	 * @return void
     */
    protected function loadHelpers()
    {
        foreach(glob(__DIR__.'/Helpers/*.php') as $filename){
            require_once $filename;
        }

        // Load helpers from FaturHelper
        if(File::exists(base_path('vendor/ajifatur/faturhelper/src'))){
            foreach(glob(base_path('vendor/ajifatur/faturhelper/src').'/HelpersExt/*.php') as $filename){
                require_once $filename;
            }
        }
	}
}