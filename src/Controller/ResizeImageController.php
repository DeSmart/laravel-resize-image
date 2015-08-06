<?php namespace DeSmart\ResizeImage\Controller;

use Illuminate\Http\Response;
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

    /**
     * Creates the image and returns it.
     *
     * @param string $path
     * @return Response
     */
    public function getImage($path)
    {
        return new Response(
            $this->resizeImage->getImage($path)
        );
    }
}
