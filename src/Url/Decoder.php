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
        $uriParts = explode('/', $uri);
        $filePart = array_pop($uriParts);

        return new UrlObject(
            $this->getPath($uriParts),
            $this->getFileName($filePart),
            $this->getResizeParams($filePart)
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
     * Returns file's path (without name).
     *
     * @param array $uriParts
     * @return string
     */
    protected function getPath(array $uriParts = [])
    {
        return join('/', $uriParts);
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
        $definitionArray = explode('_', $filePart);

        if (1 === count($definitionArray)) {
            return [];
        }

        foreach ($definitionArray as $optionSet) {
            list($option, $value) = explode('-', $optionSet);

            $options[$option] = $value;
        }

        return $options;
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
