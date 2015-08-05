<?php namespace spec\DeSmart\ResizeImage\Driver;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;

class LazyResizeDriverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('DeSmart\ResizeImage\Driver\LazyResizeDriver');
    }
}
