<?php namespace DeSmart\ResizeImage;

use DeSmart\ResizeImage\Url\Decoder;
use DeSmart\ResizeImage\Driver\DriverInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class responsible for making and returning a resized image.
 *
 * @package DeSmart\ResizeImage
 */
class ResizeImage
{

    /**
     * @var \DeSmart\ResizeImage\Driver\DriverInterface
     */
    protected $driver;

    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Creates and returns the resized image.
     *
     * @param string $path
     * @return mixed
     */
    public function getImage($path)
    {
        $urlObject = Decoder::decodePath($path);

        if (false === $this->originalFileExists($urlObject)) {
            throw new NotFoundHttpException(sprintf('File "%s" not found', $urlObject->getFullPath()));
        }

        $imageConfig = ImageConfig::createFromUrlObject($urlObject);

        return $this->driver->createImage($urlObject, $imageConfig);
    }

    /**
     * Returns true if the original image exists.
     *
     * @param UrlObject $urlObject
     * @return bool
     */
    protected function originalFileExists(UrlObject $urlObject)
    {
        return $this->driver->exists($urlObject->getFullPath());
    }
}
