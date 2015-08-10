<?php namespace spec\DeSmart\ResizeImage\Driver;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use DeSmart\ResizeImage\UrlObject;

class LazyResizeDriverSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('http://foo.bar/upload');
    }

    public function it_returns_upload_url()
    {
        $urlObject = new UrlObject('10/20', 'img.jpg');

        $this->getUrl($urlObject)->shouldBe('http://foo.bar/upload/10/20/img.jpg');
    }
}
