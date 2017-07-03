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
     * @param array $timeIntervals1
     * @param int $nonOverlapTime
     *
     * @return void
     */
    public function testGetNonOverlap($timeIntervals, $nonOverlapTime)
    {
        //dd($timeIntervals);
        $nonOverlapTimeCalculator = new NonOverlapTimeCalculator($timeIntervals);
        $this->assertSame($nonOverlapTime, $nonOverlapTimeCalculator->getNonOverlap());

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
        ];

    }
}
