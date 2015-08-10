<?php namespace DeSmart\ResizeImage\Driver;

use DeSmart\ResizeImage\UrlObject;
use DeSmart\ResizeImage\Url\Encoder;

class LazyResizeDriver implements DriverInterface
{

    /**
     * @var Base upload URL.
     */
    protected $uploadUrl;

    public function __construct($uploadUrl)
    {
        $this->uploadUrl = $uploadUrl;
    }

    /**
     * Returns image URL based on an UrlObject instance.
     *
     * @param UrlObject $urlObject
     * @return string
     */
    public function getUrl(UrlObject $urlObject)
    {
        return $this->uploadUrl.'/'.Encoder::encodeFromUrlObject($urlObject);
    }
}
