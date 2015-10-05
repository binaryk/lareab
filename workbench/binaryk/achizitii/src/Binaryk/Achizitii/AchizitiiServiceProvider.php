<?php namespace Binaryk\Achizitii;

use Illuminate\Support\ServiceProvider;

class AchizitiiServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('binaryk/achizitii'); 

		foreach (glob(__DIR__ . '/../../routes/*.php') as $filename)
		{
			require_once $filename;
		}	
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['achizitie'] = $this->app->share(function($app)
		{
			return new Achizitie;
		});
		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Achizitie', 'Binaryk\Achizitii\Facades\Achizitie');
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
