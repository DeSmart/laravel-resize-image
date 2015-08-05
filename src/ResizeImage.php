<?php namespace DeSmart\ResizeImage;

use DeSmart\Files\Entity\FileEntity;

/**
 * Class responsible for fetching URL of the image.
 *
 * @package DeSmart\ResizeImage
 */
class ResizeImage
{

    /**
     * @var \DeSmart\ResizeImage\Driver\DriverInterface
     */
    protected $driver;

    public function __construct($driver)
    {
        $this->driver = $driver;
    }

    public function getUrl(FileEntity $file, $config)
    {
        // TODO: write logic here
    }
}
