<?php namespace spec\DeSmart\ResizeImage;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use DeSmart\ResizeImage\UrlObject;

class ImageConfigSpec extends ObjectBehavior
{
    function it_builds_the_object_based_on_url_object()
    {
        $urlObject = new UrlObject('foo', 'bar.baz', [
            'w' => '600',
            'h' => '250',
            'fit' => 'crop',
            'g' => '1',
            's' => '15',
            'b' => '75',
        ]);

        $this->beConstructedWith($urlObject->getResizeParams());

        $this->getWidth()->shouldBe(600);
        $this->getHeight()->shouldBe(250);
        $this->getFit()->shouldBe('crop');
        $this->getGreyscale()->shouldBe('1');
        $this->getSharpen()->shouldBe(15);
        $this->getBlur()->shouldBe(75);
    }

    function it_ignores_invalid_values()
    {
        $urlObject = new UrlObject('foo', 'bar.baz', [
            'w' => '600',
            'foo' => '250',
        ]);

        $this->beConstructedWith($urlObject->getResizeParams());

        $this->getWidth()->shouldBe(600);
        $this->getHeight()->shouldBe(null);
    }

    function it_has_setters_to_manually_set_values()
    {
        $this->width(300)
            ->height(200)
            ->fit('crop');

        $this->getWidth()->shouldBe(300);
        $this->getHeight()->shouldBe(200);
        $this->getFit()->shouldBe('crop');
    }

    function it_returns_registered_params()
    {
        $this->width(300)
            ->height(200)
            ->fit();

        $this->getParams()->shouldBe([
            'w' => 300,
            'h' => 200,
            'fit' => true,
        ]);
    }

    function it_remembers_ratio_setting()
    {
        $this->width(450)
            ->height(300)
            ->keepRatio();
        
        $this->getParams()->shouldBe([
            'w' => 450,
            'h' => 300,
            'ratio' => true
        ]);
    }
}
