<?php namespace Codecorner\UpDownGallery;

use Illuminate\Support\ServiceProvider;

class UpDownGalleryServiceProvider extends ServiceProvider {

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
		$this->package('codecorner/up-down-gallery');
		include __DIR__ . '/../../routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['up-down-gallery'] = $this->app->share(function($app)
		{
			return new UpDownGallery;
		});
		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('UpDownGallery', 'Codecorner\UpDownGallery\Facades\UpDownGallery');
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
