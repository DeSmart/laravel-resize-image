<?php namespace spec\DeSmart\ResizeImage;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use Intervention\Image\Image;
use DeSmart\ResizeImage\ImageConfig;
use DeSmart\ResizeImage\Url\Decoder;
use DeSmart\ResizeImage\Driver\DriverInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ResizeImageSpec extends ObjectBehavior
{
    function let(DriverInterface $driver)
    {
        $this->beConstructedWith($driver);
    }

    function it_returns_an_image(DriverInterface $driver)
    {
        $path = 'foo/bar.jpg';
        $urlObject = Decoder::decodePath($path);
        $imageConfig = ImageConfig::createFromUrlObject($urlObject);

        $driver->exists($path)->willReturn(true);
        $driver->createImage($urlObject, $imageConfig)->shouldBeCalled()->willReturn($image = new Image);

        $this->getImage($path)->shouldReturn($image);
    }

    function it_throws_exception_when_original_image_does_not_exist(DriverInterface $driver)
    {
        $path = 'foo/bar.jpg';

        $driver->exists($path)->willReturn(false);

        $this->shouldThrow(NotFoundHttpException::class)->during('getImage', [$path]);
    }
}
