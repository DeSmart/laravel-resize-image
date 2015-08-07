<?php namespace DeSmart\ResizeImage\Driver;

use DeSmart\ResizeImage\UrlObject;
use DeSmart\ResizeImage\ImageConfig;

/**
 * Resize image driver interface.
 *
 * @package DeSmart\ResizeImage\Driver
 */
interface DriverInterface
{

    /**
     * Returns true if the file exists.
     *
     * @param string $fileName
     * @return bool
     */
    public function exists($fileName);

    /**
     * Creates an image based on ImageConfig, modifies and returns it.
     *
     * @param UrlObject $urlObject
     * @param ImageConfig $imageConfig
     * @return mixed
     */
    public function createImage(UrlObject $urlObject, ImageConfig $imageConfig);

    /**
     * Returns upload URL.
     *
     * @return string
     */
    public function getUploadUrl();
}
