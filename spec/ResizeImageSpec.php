<?php namespace spec\DeSmart\ResizeImage;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use Intervention\Image\Image;
use DeSmart\ResizeImage\UrlObject;
use Intervention\Image\ImageManager;
use Illuminate\Filesystem\FilesystemAdapter;
use DeSmart\ResizeImage\FileNotFoundException;

class ResizeImageSpec extends ObjectBehavior
{
    function let(FilesystemAdapter $storage, ImageManager $imageManager)
{
    $this->beConstructedWith($storage, $imageManager);
}

    function it_throws_exception_when_original_image_does_not_exist(FilesystemAdapter $storage)
    {
        $urlObject = new UrlObject('foo', 'bar.jpg');

        $storage->exists($urlObject->getFullPath())->willReturn(false);

        $this->shouldThrow(FileNotFoundException::class)->during('resize', [$urlObject]);
    }

    public function it_returns_an_image(FilesystemAdapter $storage, ImageManager $imageManager, Image $image)
    {
        $image->encode(Argument::any())->shouldBeCalled()->willReturn('image');

        $imageManager->make('resource')->shouldBeCalled()->willReturn($image);

        $storage->exists('foo/bar.jpg')->shouldBeCalled()->willReturn(true);
        $storage->get('foo/bar.jpg')->shouldBeCalled()->willReturn('resource');
        $storage->put('resize/foo/bar.jpg', $image->getWrappedObject()->encode(Argument::any()))->shouldBeCalled();

        $urlObject = new UrlObject('foo', 'bar.jpg');

        $this->resize($urlObject)->shouldBe($image);
    }
}
