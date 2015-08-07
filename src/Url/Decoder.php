<?php namespace DeSmart\ResizeImage\Url;

use DeSmart\ResizeImage\UrlObject;

/**
 * URL decoder responsible for fetching various data from the image's URL.
 *
 * @package Ggd\Files\Image\Url
 */
class Decoder
{

    /**
     * Decodes a part of the URL and returns an UrlObject.
     *
     * @param string $uri
     * @return UrlObject
     */
    public function decode($uri)
    {
        $dir = dirname($uri);
        $basename = basename($uri);

        return new UrlObject(
            $dir,
            $this->getFileName($basename),
            $this->getResizeParams($basename),
            $this->getResizeParamsRaw($basename)
        );
    }

    /**
     * Returns file's name.
     *
     * @param string $filePart
     * @return string
     */
    protected function getFileName($filePart)
    {
        $fileName = explode('--', $filePart);

        return (2 === count($fileName)) ? $fileName[1] : $fileName[0];
    }

    /**
     * Returns resize params.
     *
     * @param string $filePart
     * @return array
     */
    protected function getResizeParams($filePart)
    {
        $options = [];
        $definitionArray = explode('--', $filePart);

        if (1 === count($definitionArray)) {
            return [];
        }

        $definitionArray = explode('_', $definitionArray[0]);

        foreach ($definitionArray as $optionSet) {
            list($option, $value) = explode('-', $optionSet);

            $options[$option] = $value;
        }

        return $options;
    }

    /**
     * Returns resize params in raw format.
     *
     * @param string $filePart
     * @return string
     */
    protected function getResizeParamsRaw($filePart)
    {
        $params = explode('--', $filePart);

        return (2 === count($params)) ? $params[0] : null;
    }

    /**
     * Decodes a part of the URL and returns an UrlObject.
     *
     * @param string $path
     * @return UrlObject mixed
     */
    public static function decodePath($path)
    {
        $decoder = new static;

        return $decoder->decode($path);
    }
}
