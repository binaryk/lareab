<?php namespace Codecorner\Banca;

use Illuminate\Support\ServiceProvider;

class BancaServiceProvider extends ServiceProvider {

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
		$this->package('codecorner/banca');
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
		$this->app['banca'] = $this->app->share(function($app)
		{
			return new Banca;
		});
		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Banca', 'Codecorner\Banca\Facades\Banca');
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
