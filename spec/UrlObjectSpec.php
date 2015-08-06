<?php namespace spec\DeSmart\ResizeImage;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;

class UrlObjectSpec extends ObjectBehavior
{
    function it_has_proper_getters()
    {
        $this->beConstructedWith($path = 'some/dir', $fileName = 'foo.bar', $resizeParams = ['fit' => 'right']);

        $this->getPath()->shouldBe($path);
        $this->getFileName()->shouldBe($fileName);
        $this->getResizeParams()->shouldBe($resizeParams);
    }
}
