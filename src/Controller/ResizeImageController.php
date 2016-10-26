<?php namespace DeSmart\ResizeImage\Controller;

use DeSmart\ResizeImage\Url\Decoder;
use DeSmart\ResizeImage\ResizeImage;
use DeSmart\ResizeImage\FileNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        try {
            $urlObject = Decoder::decodePath($path);
            $image = $this->resizeImage->resize($urlObject);

            return $image->response();
        } catch (FileNotFoundException $e) {
            throw new NotFoundHttpException;
        }
    }
}
