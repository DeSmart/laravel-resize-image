<?php namespace spec\DeSmart\ResizeImage\Url;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use DeSmart\ResizeImage\UrlObject;

class DecoderSpec extends ObjectBehavior
{
    function it_decodes_simple_paths()
    {

        // No dirs
        $path = 'file.jpg';
        $expected = new UrlObject('', 'file.jpg', []);

        $this->decode($path)
            ->shouldBeLike($expected);

        // One dir
        $path = 'dir/file.jpg';
        $expected = new UrlObject('dir', 'file.jpg', []);

        $this->decode($path)
            ->shouldBeLike($expected);

        // Several dirs
        $path = 'sub/dir/deeper/file.jpg';
        $expected = new UrlObject('sub/dir/deeper', 'file.jpg', []);

        $this->decode($path)
            ->shouldBeLike($expected);
    }

    function it_decodes_resize_params()
    {
        $path = 'sub/dir/deeper/w-50_h-90_fit-crop--file.jpg';
        $expected = new UrlObject('sub/dir/deeper', 'file.jpg', [
            'w' => '50',
            'h' => '90',
            'fit' => 'crop',
        ]);

        $this->decode($path)
            ->shouldBeLike($expected);
    }
}
