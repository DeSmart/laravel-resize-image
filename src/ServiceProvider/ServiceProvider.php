<?php namespace DeSmart\ResizeImage\ServiceProvider;

use DeSmart\ResizeImage\ResizeImage;
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

        $this->registerResizeImage();
    }

    protected function configure()
    {
        $this->mergeConfigFrom($this->configPath, 'desmart_resize_image');
    }

    protected function registerResizeImage()
    {
        $config = $this->app['config']->get('desmart_resize_image');
        $driver = '\\DeSmart\\ResizeImage\\Driver\\'.$config['driver'];

        if (false === class_exists($driver)) {
            throw new DriverDoesNotExistException;
        }

        $this->app->bind(ResizeImage::class, function () use ($driver) {
            return new ResizeImage(
                $this->app->make($driver)
            );
        });
    }
}
