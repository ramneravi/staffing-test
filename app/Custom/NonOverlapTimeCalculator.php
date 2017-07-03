<?php

namespace App\Custom;


/**
 * Calculates the total non-overlap time in a given set of time intervals.
 *
 */
class NonOverlapTimeCalculator {

    /**
     * @var int
     */
    private $totalNonOverlapTime;

    private $timeIntervals;

    private $compareInterval = null;

    private $cursor;


    /**
     * @param Array $timeIntervals
     *
     */
    public function __construct($timeIntervals) {
        $this->timeIntervals = $timeIntervals;
        $this->sortTimeIntervalsByStartTime();
        $this->addADayToNextDayEndTime();
        $this->compareTimeIntervals();
    }

    /**
     * @return int
     * Returns the total non overlap time in minutes
     */
    public function getNonOverlap() {
        return ($this->totalNonOverlapTime/60);
    }

    private function compareTimeIntervals()
    {
        $timeIntervals = $this->timeIntervals;
        $this->cursor = $timeIntervals[0]['startTime'];

        foreach ($timeIntervals as $key=>$timeInterval) {

            if ($this->compareInterval == null && $timeInterval['endTime']->lte($this->cursor)) {
                continue;
            } elseif ($this->compareInterval == null) {
                $timeInterval['startTime'] = $this->cursor;
                $this->compareInterval = $timeInterval;
                continue;
            } else {
                $this->calculateNonOverlapTime($timeInterval);
            }

        }

        if ($this->compareInterval != null) {
            $this->totalNonOverlapTime += $this->compareInterval['endTime']->diffInSeconds($this->compareInterval['startTime']);
        }

    }

    private function calculateNonOverlapTime($currentInterval)
    {
        $currentStartTime = $currentInterval['startTime'];
        $currentEndTime = $currentInterval['endTime'];

        $compareStartTime = $this->compareInterval['startTime'];
        $compareEndTime = $this->compareInterval['endTime'];

        if ($currentEndTime->lte($this->cursor)) {
            // If current Intervals end time below cursor then skip this iteration
            return;
        } elseif ($currentStartTime->lt($this->cursor)) {
            // If current Intervals start time below cursor then move the current Interval start time to cursor
            $currentStartTime = $this->cursor;
        }

        if ($compareStartTime->lt($this->cursor)){
            $compareStartTime = $this->cursor;
        }


        if ($currentStartTime->eq($compareStartTime) && $currentEndTime->lt($compareEndTime)) {
            // compare  ________
            // current  _____

            $this->compareInterval = ['startTime' => $currentEndTime, 'endTime' => $compareEndTime];
            $this->cursor = $currentEndTime;

        } elseif ($currentStartTime->eq($compareStartTime) && $currentEndTime->eq($compareEndTime)) {
            // compare  ________
            // current  ________

            $this->compareInterval = null;
            $this->cursor = $currentEndTime;


        } elseif ($currentStartTime->eq($compareStartTime) && $currentEndTime->gt($compareEndTime)) {
            // compare  ________
            // current  ____________

            $this->compareInterval = ['startTime' => $compareEndTime, 'endTime' => $currentEndTime];
            $this->cursor = $compareEndTime;

        } elseif($currentStartTime->gt($compareStartTime) && $currentEndTime->lt($compareEndTime)) {
            // compare  ________
            // current    _____

            $this->totalNonOverlapTime += $currentStartTime->diffInSeconds($compareStartTime);
            $this->compareInterval = ['startTime' => $currentEndTime, 'endTime' => $compareEndTime];
            $this->cursor = $currentEndTime;

        } elseif ($currentStartTime->gt($compareStartTime) && $currentEndTime->eq($compareEndTime)) {
            // compare  ________
            // current    ______

            $this->totalNonOverlapTime += $currentStartTime->diffInSeconds($compareStartTime);
            $this->compareInterval = null;
            $this->cursor = $currentEndTime;

        } elseif ($currentStartTime->gt($compareStartTime) && $currentEndTime->gt($compareEndTime)) {
            // compare  ________
            // current    __________

            $this->totalNonOverlapTime += $currentStartTime->diffInSeconds($compareStartTime);
            $this->compareInterval = ['startTime' => $compareEndTime, 'endTime' => $currentEndTime];
            $this->cursor = $compareEndTime;

        } elseif ($currentStartTime->gte($compareEndTime)) {
            // compare  ________
            // current          __________

            $this->totalNonOverlapTime->add($compareEndTime->diff($compareStartTime));
            $this->compareInterval = $currentInterval;
            $this->cursor = $compareEndTime;

        }

    }


    /**
     * This method sort the timeIntervals array assending order by starttime
     */
    private function sortTimeIntervalsByStartTime()
    {
        usort($this->timeIntervals, function ($item1, $item2) {
            if ($item1['startTime']->eq($item2['startTime'])) return 0;
            return $item1['startTime']->lt($item2['startTime']) ? -1 : 1;
        });
    }

    /**
     *  This method walk through the array elements and checks if any of the elements end time lesser than starttime
     *  then it adds day into the end time
     */
    private function addADayToNextDayEndTime()
    {
        array_walk($this->timeIntervals, function(&$item) {
            if($item['endTime']->lt($item['startTime'])) $item['endTime']->addDay();
        });
    }

}