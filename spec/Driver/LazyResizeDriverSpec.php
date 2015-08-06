<?php namespace spec\DeSmart\ResizeImage\Driver;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use Illuminate\Filesystem\FilesystemAdapter;
use Intervention\Image\ImageManager as Image;

class LazyResizeDriverSpec extends ObjectBehavior
{
    function let(FilesystemAdapter $storage, Image $image)
    {
        $this->beConstructedWith($storage, $image);
    }

    function it_checks_if_the_file_exists(FilesystemAdapter $storage)
    {
        $storage->exists('foo.jpg')->shouldBeCalled()->willReturn(false);

        $this->exists('foo.jpg')->shouldReturn(false);

        $storage->exists('foo.jpg')->shouldBeCalled()->willReturn(true);

        $this->exists('foo.jpg')->shouldReturn(true);
    }
}
