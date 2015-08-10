<?php namespace DeSmart\ResizeImage\Driver;

use DeSmart\ResizeImage\UrlObject;

/**
 * Resize image driver interface.
 *
 * @package DeSmart\ResizeImage\Driver
 */
interface DriverInterface
{

    /**
     * Returns image URL based on an UrlObject instance.
     *
     * @param UrlObject $urlObject
     * @return string
     */
    public function getUrl(UrlObject $urlObject);
}
