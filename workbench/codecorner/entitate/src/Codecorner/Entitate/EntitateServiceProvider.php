<?php namespace Codecorner\Entitate;

use Illuminate\Support\ServiceProvider;

class EntitateServiceProvider extends ServiceProvider {

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
		$this->package('codecorner/entitate');
		//include __DIR__ . '/../../routes.php';
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
		$this->app['entitate'] = $this->app->share(function($app)
		{
			return new Entitate;
		});
		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Entitate', 'Codecorner\Entitate\Facades\Entitate');
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
