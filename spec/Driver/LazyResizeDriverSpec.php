<?php namespace spec\DeSmart\ResizeImage\Driver;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use Intervention\Image\Image;
use DeSmart\ResizeImage\UrlObject;
use DeSmart\ResizeImage\ImageConfig;
use Intervention\Image\ImageManager;
use Illuminate\Filesystem\FilesystemAdapter;

class LazyResizeDriverSpec extends ObjectBehavior
{
    function let(FilesystemAdapter $storage, ImageManager $imageManager)
    {
        $this->beConstructedWith($storage, $imageManager, 'http://foo.bar/upload');
    }

    function it_checks_if_the_file_exists(FilesystemAdapter $storage)
    {
        $storage->exists('foo.jpg')->shouldBeCalled()->willReturn(false);

        $this->exists('foo.jpg')->shouldReturn(false);

        $storage->exists('foo.jpg')->shouldBeCalled()->willReturn(true);

        $this->exists('foo.jpg')->shouldReturn(true);
    }

    public function it_returns_an_image(FilesystemAdapter $storage, ImageManager $imageManager, Image $image)
    {
        $image->response()->shouldBeCalled()->willReturn('image');

        $imageManager->make('resource')->shouldBeCalled()->willReturn($image);

        $storage->get('foo/bar.jpg')->shouldBeCalled()->willReturn('resource');
        $storage->put('resize/foo/bar.jpg', $image->getWrappedObject()->response())->shouldBeCalled();

        $urlObject = new UrlObject('foo', 'bar.jpg');
        $imageConfig = new ImageConfig($urlObject->getResizeParams());

        $this->createImage($urlObject, $imageConfig)->shouldBe($image);
    }

    public function it_returns_upload_url()
    {
        $this->getUploadUrl()->shouldBe('http://foo.bar/upload');
    }
}
