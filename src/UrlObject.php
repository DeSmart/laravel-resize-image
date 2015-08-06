<?php namespace DeSmart\ResizeImage;

class UrlObject
{

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var array
     */
    protected $resizeParams;

    public function __construct($path, $fileName, $resizeParams)
    {
        $this->path = $path;
        $this->fileName = $fileName;
        $this->resizeParams = $resizeParams;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @return array
     */
    public function getResizeParams()
    {
        return $this->resizeParams;
    }
}
