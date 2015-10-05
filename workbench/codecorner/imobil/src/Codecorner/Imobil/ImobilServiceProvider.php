<?php namespace Codecorner\Imobil;

use Illuminate\Support\ServiceProvider;

class ImobilServiceProvider extends ServiceProvider {

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
		$this->package('codecorner/imobil');
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
		$this->app['imobil'] = $this->app->share(function($app)
		{
			return new Imobil;
		});
		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Imobil', 'Codecorner\Imobil\Facades\Imobil');
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
