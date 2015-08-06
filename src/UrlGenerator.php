<?php namespace DeSmart\ResizeImage;

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

    public function getUrl(FileEntity $file, $config)
    {
        // @todo write logic here
    }
}
