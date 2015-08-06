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
        'g' => 'greyscale',
        's' => 'sharpen',
        'b' => 'blur',
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

    public function fit($fit)
    {
        return $this->setParam('fit', $fit);
    }

    public function getFit()
    {
        return $this->getParam('fit');
    }

    public function greyscale($greyscale)
    {
        return $this->setParam('greyscale', $greyscale);
    }

    public function getGreyscale()
    {
        return $this->getParam('greyscale');
    }

    public function sharpen($sharpen)
    {
        return $this->setParam('sharpen', (int)$sharpen);
    }

    public function getSharpen()
    {
        return $this->getParam('sharpen');
    }

    public function blur($blur)
    {
        return $this->setParam('blur', (int)$blur);
    }

    public function getBlur()
    {
        return $this->getParam('blur');
    }
}
