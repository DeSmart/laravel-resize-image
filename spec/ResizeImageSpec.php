<?php namespace spec\DeSmart\ResizeImage;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use DeSmart\Files\Entity\FileEntity;
use DeSmart\ResizeImage\Driver\LazyResizeDriver;

class ResizeImageSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(LazyResizeDriver::class);
    }

    function it_returns_proper_url()
    {
        $file = new FileEntity;
        $file->setPath('foo/bar/baz.png');

        $config = [];

        $this->getUrl($file, $config);
    }
}
