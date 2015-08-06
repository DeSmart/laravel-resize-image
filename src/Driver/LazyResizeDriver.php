<?php namespace DeSmart\ResizeImage\Driver;

use DeSmart\ResizeImage\UrlObject;
use DeSmart\ResizeImage\ImageConfig;
use DeSmart\ResizeImage\Url\Encoder;
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

        // Make the image
        $image = $this->makeImage($imageConfig, $urlObject->getFullPath());

        $targetFilePath = Encoder::encodeFromUrlObject($urlObject);

        // Store the image
        $this->storage->put('resize/'.$targetFilePath, $image->response());

        return $image;
    }

    /**
     * Make the image and apply modifications.
     *
     * @param ImageConfig $imageConfig
     * @param string $path
     * @return \Intervention\Image\Image
     */
    protected function makeImage(ImageConfig $imageConfig, $path)
    {
        $image = $this->image->make($this->storage->get($path));

        $width = $imageConfig->getWidth();
        $height = $imageConfig->getHeight();

        // Resize / crop
        if (false === is_null($width) && false === is_null($height)) {
            if ($imageConfig->getFit()) {
                $image->fit($width, $height);
            }
            else {
                $image->resize($width, $height);
            }
        }

        // Greyscale
        if ($imageConfig->getGreyscale()) {
            $image->greyscale();
        }

        // Sharpen / blur
        if ($imageConfig->getSharpen()) {
            $image->sharpen($imageConfig->getSharpen());
        }
        else if ($imageConfig->getBlur()) {
            $image->blur($imageConfig->getBlur());
        }

        return $image;
    }
}
