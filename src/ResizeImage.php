<?php namespace DeSmart\ResizeImage;

use DeSmart\ResizeImage\Url\Encoder;
use Intervention\Image\ImageManager;
use Illuminate\Filesystem\FilesystemAdapter;

/**
 * Class responsible for making and returning a resized image.
 *
 * @package DeSmart\ResizeImage
 */
class ResizeImage
{

    /**
     * @var FilesystemAdapter
     */
    protected $storage;

    /**
     * @var ImageManager
     */
    protected $imageManager;

    public function __construct(FilesystemAdapter $storage, ImageManager $imageManager)
    {
        $this->storage = $storage;
        $this->imageManager = $imageManager;
    }

    /**
     * Creates and returns the resized image.
     *
     * @param UrlObject $urlObject
     * @throws FileNotFoundException
     * @return mixed
     */
    public function resize(UrlObject $urlObject)
    {
        if (false === $this->exists($urlObject->getFullPath())) {
            throw new FileNotFoundException(sprintf('File "%s" not found', $urlObject->getFullPath()));
        }

        return $this->createImage(
            $urlObject
        );
    }

    /**
     * Returns true if the file exists.
     *
     * @param string $fileName
     * @return bool
     */
    protected function exists($fileName)
    {
        return $this->storage->exists($fileName);
    }

    /**
     * Creates an image based on ImageConfig, modifies and returns it.
     *
     * @param UrlObject $urlObject
     * @return mixed
     */
    protected function createImage(UrlObject $urlObject)
    {
        $imageConfig = ImageConfig::createFromUrlObject($urlObject);

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
        $image = $this->imageManager->make($this->storage->get($path));

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
