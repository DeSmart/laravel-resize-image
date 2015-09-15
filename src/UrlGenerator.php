<?php namespace DeSmart\ResizeImage;

use DeSmart\ResizeImage\Url\Encoder;
use DeSmart\Files\Entity\FileEntity;
use DeSmart\ResizeImage\Driver\DriverInterface;

/**
 * Class responsible for fetching URL of the image.
 *
 * @package DeSmart\ResizeImage
 */
class UrlGenerator
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
     * Generates an image URL for the file
     *
     * @param FileEntity $file
     * @param ImageConfig $imageConfig
     * @return string
     */
    public function getUrl(FileEntity $file, ImageConfig $imageConfig = null)
    {
        if (null === $imageConfig) {
            $imageConfig = new ImageConfig;
        }

        $urlObject = new UrlObject(
            dirname($file->getPath()),
            basename($file->getPath()),
            $imageConfig->getParams()
        );

        return $this->driver->getUrl($urlObject);
    }
}
