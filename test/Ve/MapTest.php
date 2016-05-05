<?php

namespace Ve;

class MapTest extends \PHPUnit_Framework_TestCase
{
    public function testMapWithKey()
    {
        $quarterlyProfit = 3000.30;
        $monthAbbrevations = ['jan', 'feb', 'mar'];
        $expectedResult = [
            'jan' => 1000.10,
            'feb' => 1000.10,
            'mar' => 1000.10,
        ];

        $profitPerMonth = mapWithKey($monthAbbrevations, function ($monthAbbrev) use ($quarterlyProfit)  {
            return [
                $monthAbbrev => $quarterlyProfit / 3,
             ];
        });

        $this->assertEquals($expectedResult, $profitPerMonth);
    }
}
