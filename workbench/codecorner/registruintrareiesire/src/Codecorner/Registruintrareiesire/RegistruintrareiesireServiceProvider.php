<?php namespace Codecorner\Registruintrareiesire;

use Illuminate\Support\ServiceProvider;

class RegistruintrareiesireServiceProvider extends ServiceProvider {

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
		$this->package('codecorner/registruintrareiesire');
		include __DIR__ . '/../../routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['registruintrareiesire'] = $this->app->share(function($app)
		{
			return new Registruintrareiesire;
		});
		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Registruintrareiesire', 'Codecorner\Registruintrareiesire\Facades\Registruintrareiesire');
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
