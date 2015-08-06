<?php namespace DeSmart\ResizeImage\Driver;

use DeSmart\ResizeImage\UrlObject;
use DeSmart\ResizeImage\ImageConfig;
use Illuminate\Filesystem\FilesystemAdapter;
use Intervention\Image\ImageManager as Image;

class LazyResizeDriver implements DriverInterface
{

    /**
     * @var FilesystemAdapter
     */
    protected $storage;

    /**
     * @var Image
     */
    protected $image;

    public function __construct(FilesystemAdapter $storage, Image $image)
    {
        $this->storage = $storage;
        $this->image = $image;
    }

    /**
     * Returns true if the file exists.
     *
     * @param string $fileName
     * @return bool
     */
    public function exists($fileName)
    {
        return $this->storage->exists($fileName);
    }

    /**
     * Creates an image based on ImageConfig, modifies and returns it.
     *
     * @param UrlObject $urlObject
     * @param ImageConfig $imageConfig
     * @return mixed
     */
    public function createImage(UrlObject $urlObject, ImageConfig $imageConfig)
    {
        $image = $this->image->make($this->storage->get($urlObject->getFullPath()))->resize(300, 200);

        $this->storage->put('resize/'.$urlObject->getFullPath(), $image->response());

        return $image;
    }
}
