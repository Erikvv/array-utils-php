<?php

namespace Ve;

class LockstepIteratorTest extends \PHPUnit_Framework_TestCase
{
    public function testIntArrays()
    {
        $in1 = [1,2,3,4];
        $in2 = [5,6,7,8,9];
        $expectedResult = [[1,5], [2,6], [3,7], [4,8]];

        $result = [];

        $lockstepIterator = new LockstepIterator(
                new \ArrayIterator($in1),
                new \ArrayIterator($in2));

        foreach ($lockstepIterator as $pair) {
            $result[] = $pair;
        }

        $this->assertEquals($result, $expectedResult);
    }
}
