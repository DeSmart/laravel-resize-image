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

    /**
     * @var string
     */
    protected $resizeParamsRaw;

    public function __construct($path, $fileName, array $resizeParams = [], $resizeParamsRaw = '')
    {
        $this->path = $path;
        $this->fileName = $fileName;
        $this->resizeParams = $resizeParams;
        $this->resizeParamsRaw = $resizeParamsRaw;
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

    /**
     * @return string
     */
    public function getFullPath()
    {
        return $this->getPath().'/'.$this->getFileName();
    }

    /**
     * @return string
     */
    public function getResizeParamsRaw()
    {
        return $this->resizeParamsRaw;
    }
}
