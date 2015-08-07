<?php namespace spec\DeSmart\ResizeImage;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use DeSmart\ResizeImage\ImageConfig;
use DeSmart\Files\Entity\FileEntity;
use DeSmart\ResizeImage\Driver\DriverInterface;

class UrlGeneratorSpec extends ObjectBehavior
{
    function let(DriverInterface $driver)
    {
        $this->beConstructedWith($driver);
    }

    function it_returns_proper_url(DriverInterface $driver)
    {
        $driver->getUploadUrl()->willReturn($url = 'http://foo.bar/baz');

        $file = new FileEntity;
        $file->setPath('10/20/foo.jpg');
        $file->setName('foo.jpg');

        $imageConfig = new ImageConfig;
        $imageConfig->width(600)
            ->height(400)
            ->blur(15)
            ->greyscale();

        $expected = $url.'/10/20/w-600_h-400_b-15_g-1--foo.jpg';

        $this->getUrl($file, $imageConfig)->shouldBe($expected);
    }

    function it_generates_url_without_image_config(DriverInterface $driver)
    {
        $driver->getUploadUrl()->willReturn($url = 'http://foo.bar/baz');

        $file = new FileEntity;
        $file->setPath('10/20/foo.jpg');
        $file->setName('foo.jpg');

        $expected = $url.'/10/20/foo.jpg';

        $this->getUrl($file)->shouldBe($expected);
    }
}
