<?php namespace DeSmart\ResizeImage\Controller;

use App\Http\Controllers\Controller;
use DeSmart\ResizeImage\ResizeImage;

class ResizeImageController extends Controller
{

    /**
     * @var ResizeImage
     */
    protected $resizeImage;

    public function __construct(ResizeImage $resizeImage)
    {
        $this->resizeImage = $resizeImage;
    }

    public function getImage($path)
    {
        $this->resizeImage->getImage($path);
    }
}
