<?php

namespace Ajifatur\Campusnet;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
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
		// Add package's view
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'campusnet');

        // Add package's migration
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
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
	}
}