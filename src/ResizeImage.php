<?php namespace DeSmart\ResizeImage;

use DeSmart\Files\Entity\FileEntity;
use DeSmart\ResizeImage\Driver\DriverInterface;
use DeSmart\ResizeImage\Url\Decoder;

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

    public function __construct(DriverInterface $driver)
    {
        $this->driver = $driver;
    }

    public function getImage($path)
    {
        $decoder = new Decoder;

        dd($decoder->decode($path));
    }
}
