<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Custom\NonOverlapTimeCalculator;

class NonOverlapTimeCalculatorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */

    /**
     * @dataProvider dataProvider
     *
     * @param array $timeIntervals
     * @param int $nonOverlapTime
     *
     * @return void
     */
    public function testGetNonOverlap($timeIntervals, $nonOverlapTime)
    {
        $nonOverlapTimeCalculator = new NonOverlapTimeCalculator($timeIntervals);
        $this->assertSame($nonOverlapTime, $nonOverlapTimeCalculator->getTotalNonOverlapTime());

    }


    public function dataProvider()
    {

        return [
            [
                [
                    ['startTime' => Carbon::today(), 'endTime' => Carbon::today()->addHour(8)],
                    ['startTime' => Carbon::today(), 'endTime' => Carbon::today()->addHour(4)],
                    ['startTime' => Carbon::today()->addHour(6), 'endTime' => Carbon::today()->addHour(10)],

                ],
                240
            ],
            [
                [
                    ['startTime' => Carbon::today(), 'endTime' => Carbon::today()->addHour(8)],
                    ['startTime' => Carbon::today(), 'endTime' => Carbon::today()->addHour(8)],
                    ['startTime' => Carbon::today()->addHour(6), 'endTime' => Carbon::today()->addHour(10)]
                ],
                120
            ],
            [
                [
                    ['startTime' => Carbon::today(), 'endTime' => Carbon::today()->addHour(6)],
                    ['startTime' => Carbon::today(), 'endTime' => Carbon::today()->addHour(8)],
                    ['startTime' => Carbon::today()->addHour(8), 'endTime' => Carbon::today()->addHour(10)]
                ],
                240
            ],
            [
                [
                    ['startTime' => Carbon::today(), 'endTime' => Carbon::today()->addHour(8)],
                    ['startTime' => Carbon::today()->addHour(4), 'endTime' => Carbon::today()->addHour(6)],
                    ['startTime' => Carbon::today()->addHour(5), 'endTime' => Carbon::today()->addHour(10)]
                ],
                360
            ],
            [
                [
                    ['startTime' => Carbon::today(), 'endTime' => Carbon::today()->addHour(8)],
                    ['startTime' => Carbon::today()->addHour(2), 'endTime' => Carbon::today()->addHour(8)],
                    ['startTime' => Carbon::today()->addHour(5), 'endTime' => Carbon::today()->addHour(6)]
                ],
                120
            ],
            [
                [
                    ['startTime' => Carbon::today(), 'endTime' => Carbon::today()->addHour(6)],
                    ['startTime' => Carbon::today()->addHour(2), 'endTime' => Carbon::today()->addHour(8)],
                    ['startTime' => Carbon::today()->addHour(5), 'endTime' => Carbon::today()->addHour(7)]
                ],
                180
            ],
            [
                [
                    ['startTime' => Carbon::today(), 'endTime' => Carbon::today()->addHour(8)],
                    ['startTime' => Carbon::today()->addHour(2), 'endTime' => Carbon::today()->addHour(12)],
                    ['startTime' => Carbon::today()->addHour(12), 'endTime' => Carbon::today()->addHour(18)]
                ],
                720
            ],
            [
                [
                    ['startTime' => Carbon::today(), 'endTime' => Carbon::today()->addHour(4)],
                    ['startTime' => Carbon::today(), 'endTime' => Carbon::today()->addHour(4)],
                    ['startTime' => Carbon::today()->addHour(4), 'endTime' => Carbon::today()->addHour(8)],
                    ['startTime' => Carbon::today()->addHour(8), 'endTime' => Carbon::today()->addHour(12)],
                    ['startTime' => Carbon::today()->addHour(8), 'endTime' => Carbon::today()->addHour(12)]
                ],
                240
            ],
            [
                [
                    ['startTime' => Carbon::today(), 'endTime' => Carbon::today()->addHour(4)],
                    ['startTime' => Carbon::today(), 'endTime' => Carbon::today()->addHour(4)],
                    ['startTime' => Carbon::today()->addHour(6), 'endTime' => Carbon::today()->addHour(8)],
                    ['startTime' => Carbon::today()->addHour(10), 'endTime' => Carbon::today()->addHour(12)],
                    ['startTime' => Carbon::today()->addHour(10), 'endTime' => Carbon::today()->addHour(12)]
                ],
                120
            ],
            [
                [
                    ['startTime' => Carbon::today(), 'endTime' => Carbon::today()->addHour(4)],
                    ['startTime' => Carbon::today()->addHour(2), 'endTime' => Carbon::today()->addHour(6)],
                    ['startTime' => Carbon::today()->addHour(6), 'endTime' => Carbon::today()->addHour(8)],
                    ['startTime' => Carbon::today()->addHour(7), 'endTime' => Carbon::today()->addHour(10)],
                    ['startTime' => Carbon::today()->addHour(8), 'endTime' => Carbon::today()->addHour(12)],
                    ['startTime' => Carbon::today()->addHour(11), 'endTime' => Carbon::today()->addHour(14)],
                    ['startTime' => Carbon::today()->addHour(11), 'endTime' => Carbon::today()->addHour(15)],
                    ['startTime' => Carbon::today()->addHour(12), 'endTime' => Carbon::today()->addHour(14)],
                    ['startTime' => Carbon::today()->addHour(15), 'endTime' => Carbon::today()->addHour(18)],
                    ['startTime' => Carbon::today()->addHour(18), 'endTime' => Carbon::today()->addHour(20)],

                ],
                720
            ],
        ];

    }
}
