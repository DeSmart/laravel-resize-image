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
        $this->registerRoutes();
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

    protected function registerRoutes()
    {
        $this->app->get('/file/{compoundPath:.+}', function ($compoundPath) {
            $pathParts = explode('/', $compoundPath);

            // File name with resize definition
            $fileDefinition = array_pop($pathParts);

            // File dir path
            $filePath = join('/', $pathParts);

            $fileParts = explode('--', $fileDefinition);

            if (1 === count($fileParts)) {
                $fileName = $fileParts[0];
            }
            else {
                $fileName = $fileParts[1];
            }

            var_dump($filePath);
            var_dump($fileName);

            $definitionArray = explode('_', $fileDefinition);

            foreach ($definitionArray as $optionSet) {
                list($option, $value) = explode('-', $optionSet);

                $optionArray[$option] = $value;
            }

            var_dump($optionArray);

            die;
        });
    }
}
