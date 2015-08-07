<?php namespace DeSmart\ResizeImage\ServiceProvider;

use DeSmart\ResizeImage\ResizeImage;
use DeSmart\ResizeImage\UrlGenerator;
use DeSmart\ResizeImage\Driver\LazyResizeDriver;
use DeSmart\ResizeImage\Driver\Exception\DriverDoesNotExistException;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $configPath;

    public function __construct($app)
    {
        parent::__construct($app);

        $this->configPath = __DIR__.'/../../config/desmart_resize_image.php';
    }

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
        $driver = 'DeSmart\\ResizeImage\\Driver\\'.$config['driver'];

        if (false === class_exists($driver)) {
            throw new DriverDoesNotExistException;
        }

        $this->app->bind(ResizeImage::class, function () use ($driver) {
            return new ResizeImage(
                $this->app->make($driver)
            );
        });

        $this->app->bind(UrlGenerator::class, function () use ($driver, $config) {
            return new UrlGenerator(
                $this->app->make($driver)
            );
        });

        $this->app->bind(LazyResizeDriver::class, function () use ($config) {
            return new LazyResizeDriver(
                $this->app->make('desmart_files.storage'),
                $this->app->make('image'),
                $config['upload_url']
            );
        });
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
