<?php namespace DeSmart\ResizeImage\ServiceProvider;

class LumenServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    protected function configure()
    {
        $this->app->configure('desmart_resize_image');

        parent::configure();
    }
}
