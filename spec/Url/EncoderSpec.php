<?php namespace spec\DeSmart\ResizeImage\Url;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use DeSmart\ResizeImage\UrlObject;

class EncoderSpec extends ObjectBehavior
{
    function it_encodes_simple_url_object_to_paths()
    {
        $urlObject = new UrlObject('sub/dir/deeper', 'file.jpg', []);
        $expected = 'sub/dir/deeper/file.jpg';

        $this->encode($urlObject)->shouldBe($expected);
    }

    function it_encodes_url_objects_with_resize_params()
    {
        $urlObject = new UrlObject('sub/dir/deeper', 'file.jpg', [
            'w' => '100',
            'h' => '250',
        ]);
        $expected = 'sub/dir/deeper/w-100_h-250--file.jpg';

        $this->encode($urlObject)->shouldBe($expected);
    }
}
