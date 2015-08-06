<?php namespace spec\DeSmart\ResizeImage;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use DeSmart\ResizeImage\Driver\DriverInterface;

class ResizeImageSpec extends ObjectBehavior
{
    function let(DriverInterface $driver)
    {
        $this->beConstructedWith($driver);
    }

    function it_returns_an_image()
    {
        /**
         * @todo write logic
         */
    }
}
