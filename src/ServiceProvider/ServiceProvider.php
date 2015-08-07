<?php namespace DeSmart\ResizeImage\ServiceProvider;

use DeSmart\ResizeImage\Driver\DriverInterface;
use DeSmart\ResizeImage\Driver\LazyResizeDriver;
use DeSmart\ResizeImage\DriverNotFoundException;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $configPath = __DIR__.'/../../config/desmart_resize_image.php';

    public function boot()
    {
        $this->publishes([
            $this->configPath => config_path('desmart_resize_image.php'),
        ]);
    }

    public function register()
    {
        $this->configure();

        $this->registerProviders();
        $this->registerClasses();
        $this->registerRoutes();
    }

    protected function configure()
    {
        $this->mergeConfigFrom($this->configPath, 'desmart_resize_image');
    }

    protected function registerClasses()
    {
        $config = $this->app['config']->get('desmart_resize_image');

        if (false === class_exists($config['driver'])) {
            throw new DriverNotFoundException;
        }

        $this->app->bind(LazyResizeDriver::class, function () use ($config) {
            return new LazyResizeDriver(
                $this->app->make('desmart_files.storage'),
                $this->app->make('image'),
                $config['upload_url']
            );
        });

        $this->app->bind(DriverInterface::class, $config['driver']);
    }

    protected function registerRoutes()
    {
        $this->app->get('/upload/resize/{path:.+}', 'DeSmart\ResizeImage\Controller\ResizeImageController@getImage');
    }

    protected function registerProviders()
    {
        $this->app->register('Intervention\Image\ImageServiceProvider');
    }
}
