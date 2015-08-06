<?php namespace DeSmart\ResizeImage\Url;

use DeSmart\ResizeImage\UrlObject;

/**
 * URL encoder responsible for converting an UrlObject into a URL part.
 *
 * @package Ggd\Files\Image\Url
 */
class Encoder
{

    /**
     * Encodes a UrlObject into a URL part.
     *
     * @param UrlObject $urlObject
     * @return string
     */
    public function encode(UrlObject $urlObject)
    {
        return sprintf(
            '%s/%s',
            $urlObject->getPath(),
            $this->encodeFileName($urlObject)
        );
    }

    public static function encodeFromUrlObject(UrlObject $urlObject)
    {
        $encoder = new static;

        return $encoder->encode($urlObject);
    }

    /**
     * Combines the file name with resize params and returns it as a string.
     *
     * @param UrlObject $urlObject
     * @return string
     */
    protected function encodeFileName(UrlObject $urlObject)
    {
        $resizeParams = $urlObject->getResizeParams();
        $fileName = $urlObject->getFileName();

        if (true === empty($resizeParams)) {
            return $fileName;
        }

        $options = [];

        foreach ($resizeParams as $option => $value) {
            $options[] = $option.'-'.$value;
        }

        return sprintf(
            '%s--%s',
            join('_', $options),
            $fileName
        );
    }
}
