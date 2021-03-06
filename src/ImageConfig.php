<?php namespace DeSmart\ResizeImage;

class ImageConfig
{

    /**
     * Values that are set (e.g. width, height).
     *
     * @var array
     */
    protected $params = [];

    /**
     * Available modifiers (methods)
     *
     * @var array
     */
    protected $methodMap = [
        'w' => 'width',
        'h' => 'height',
        'fit' => 'fit',
        'ratio' => 'keepRatio',
        'g' => 'greyscale',
        's' => 'sharpen',
        'b' => 'blur',
        'scale' => 'scale',
    ];

    public function __construct(array $resizeParams = [])
    {

        // Iterate through the resize options and set valid properties
        foreach ($resizeParams as $option => $value) {
            $methodName = $this->getSetterName($option);

            // If the setter exist, call it
            if (false === is_null($methodName) && true === method_exists($this, $methodName)) {
                call_user_func_array([$this, $methodName], [$value]);
            }
        }
    }

    /**
     * Creates an instance of ImageConfig from UrlObject.
     *
     * @param UrlObject $urlObject
     * @return $this
     */
    public static function createFromUrlObject(UrlObject $urlObject)
    {
        return new static($urlObject->getResizeParams());
    }

    /**
     * Determine the setter method name.
     *
     * @param string $shortcut
     * @return null|string
     */
    protected function getSetterName($shortcut)
    {
        if (false === array_key_exists($shortcut, $this->methodMap)) {
            return null;
        }

        return $this->methodMap[$shortcut];
    }

    /**
     * Sets the parameter's value.
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    protected function setParam($key, $value)
    {
        $this->params[$key] = $value;

        return $this;
    }

    /**
     * Returns the parameter's value.
     *
     * @param string $key
     * @return null|mixed
     */
    protected function getParam($key)
    {
        if (false === array_key_exists($key, $this->params)) {
            return null;
        }

        return $this->params[$key];
    }

    public function width($width)
    {
        return $this->setParam('width', (int)$width);
    }

    public function getWidth()
    {
        return $this->getParam('width');
    }

    public function height($height)
    {
        return $this->setParam('height', (int)$height);
    }

    public function getHeight()
    {
        return $this->getParam('height');
    }

    public function fit($fit = true)
    {
        return $this->setParam('fit', $fit);
    }

    public function getFit()
    {
        return $this->getParam('fit');
    }

    public function keepRatio($keep = true)
    {
        return $this->setParam('keepRatio', (bool)$keep);
    }

    public function getKeepRatio()
    {
        return $this->getParam('keepRatio');
    }

    public function greyscale($greyscale = true)
    {
        return $this->setParam('greyscale', $greyscale);
    }

    public function getGreyscale()
    {
        return $this->getParam('greyscale');
    }

    /**
     * Sharpen an image. Values range from 1 (slight sharpen) to 100 (maximum sharpen).
     *
     * @param int $sharpen
     * @return ImageConfig
     */
    public function sharpen($sharpen = 1)
    {
        return $this->setParam('sharpen', (int)$sharpen);
    }

    public function getSharpen()
    {
        return $this->getParam('sharpen');
    }

    /**
     * Blur an image. Values range from 1 (slight blur) to 100 (maximum blur).
     *
     * @param int $blur
     * @return ImageConfig
     */
    public function blur($blur = 1)
    {
        return $this->setParam('blur', (int)$blur);
    }

    public function getBlur()
    {
        return $this->getParam('blur');
    }

    public function scale($scale = true)
    {
        return $this->setParam('scale', $scale);
    }

    public function getScale()
    {
        return $this->getParam('scale');
    }

    /**
     * Returns all registered params with short names (e.g. "w" instead of "width").
     *
     * @return array
     */
    public function getParams()
    {
        $params = [];

        foreach ($this->params as $fullName => $value) {
            $shortcut = array_search($fullName, $this->methodMap);

            $params[$shortcut] = $value;
        }

        return $params;
    }
}
