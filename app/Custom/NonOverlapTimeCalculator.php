<?php

namespace App\Custom;


/**
 * Calculates the total non-overlap time in a given set of time intervals.
 *
 */
class NonOverlapTimeCalculator
{


    private $compareInterval = null;

    private $cursor;

    private $nonOverlapTimeIntervals = [];


    /**
     * @param Array $timeIntervals
     *
     */
    public function __construct($timeIntervals)
    {

        $this->setNonOverlapTimeIntervals($timeIntervals);

    }

    /**
     * Using set nonOverlapTimeIntervals calculates totalNonOverlapTime in Seconds
     * Returns the totalNonOverlapTime time in minutes
     * @return int
     */
    public function getTotalNonOverlapTime()
    {

        $totalNonOverlapTime = 0;

        foreach ($this->nonOverlapTimeIntervals as $interval) {
            $totalNonOverlapTime += $interval[1]->diffInSeconds($interval[0]);
        }

        return ($totalNonOverlapTime / 60);
    }


    /**
     * Set the cursor position to first element start time
     * When traversing inside the timeIntervals array skip the iteration if the elements end time below cursor
     * If current CompareInterval is null then set the current timeInterval to compareInterval and skip the iteration
     * After finishing the iterations if you find a non null compareInterval then add it to nonOverlapTimeIntervals
     *
     * @param $timeIntervals
     */
    private function setNonOverlapTimeIntervals($timeIntervals)
    {

        $timeIntervals = $this->sortTimeIntervalsByStartTime($timeIntervals);
        $timeIntervals = $this->addADayToNextDayEndTime($timeIntervals);
        $this->cursor = $timeIntervals[0]['startTime'];

        foreach ($timeIntervals as $key => $timeInterval) {

            if ($timeInterval['endTime']->gt($this->cursor)) {

                if ($this->compareInterval == null) {
                    $this->setCompareInterval($timeInterval);
                } else {
                    $compareTimes = $this->getCompareTimes($timeInterval);
                    $this->processCompareTimes($compareTimes);
                }

            }
        }

        if (isset($this->compareInterval)) {
            $this->nonOverlapTimeIntervals[] = $this->compareInterval;
        }

    }

    /**
     * Assign given timeInterval to a new CompareInterval
     * When startTime of timeInterval below the cursor then move the StartTime to cursor
     *
     * @param $timeInterval
     */
    private function setCompareInterval($timeInterval)
    {

        $startTime = ($timeInterval['startTime']->lt($this->cursor)) ? $this->cursor :  $timeInterval['startTime'];
        $endTime = $timeInterval['endTime'];
        $this->compareInterval = [$startTime, $endTime];

    }

    /**
     * Using CompareTimes and $timeInterval make a new array CompareTimes
     * If time interval StartTime is below cursor then move the StartTime to cursor
     *
     * @param $timeInterval
     * @return array
     */
    private function getCompareTimes($timeInterval)
    {
        $compareTimes = $this->compareInterval;
        $startTime = ($timeInterval['startTime']->lt($this->cursor)) ? $this->cursor : $timeInterval['startTime'];
        $endTime = $timeInterval['endTime'];

        array_push($compareTimes, $startTime, $endTime);

        return $compareTimes;
    }

    /**
     * Sort $compareTimes and call array_values with $compareTimes to change the keys according to new order
     * NonOverlapInterval is [element1, element2] of $compareTimes if they are not equal
     * New cursor position is element3 of $compareTimes
     * New compareInterval is [element3, element4] of $compareTimes if they are not equal else Null
     *
     * @param $compareTimes
     */
    private function processCompareTimes($compareTimes)
    {
        asort($compareTimes);
        $compareTimes = array_values($compareTimes);

        if ($compareTimes[0]->ne($compareTimes[1])) {
            $this->nonOverlapTimeIntervals[] = [$compareTimes[0], $compareTimes[1]];
        }

        $this->cursor = $compareTimes[2];
        $this->compareInterval = ($compareTimes[2]->eq($compareTimes[3])) ? null : [$compareTimes[2], $compareTimes[3]];

    }


    /**
     * This method sort the timeIntervals array assending order by starttime
     *
     * @param $timeIntervals
     * @return mixed
     */
    private function sortTimeIntervalsByStartTime($timeIntervals)
    {
        usort($timeIntervals, function ($item1, $item2) {
            if ($item1['startTime']->eq($item2['startTime'])) return 0;
            return $item1['startTime']->lt($item2['startTime']) ? -1 : 1;
        });

        return $timeIntervals;
    }


    /**
     *  This method walk through the array elements and checks if any of the elements end time lesser than starttime
     *  then it adds day into the end time
     *
     * @param $timeIntervals
     * @return mixed
     */
    private function addADayToNextDayEndTime($timeIntervals)
    {
        array_walk($timeIntervals, function (&$item) {
            if ($item['endTime']->lt($item['startTime'])) $item['endTime']->addDay();
        });

        return $timeIntervals;
    }

}