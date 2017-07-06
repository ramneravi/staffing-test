<?php

namespace App\Repositories;

use App\Custom\NonOverlapTimeCalculator;
use App\RotaSlotStaff;
use Illuminate\Database\Eloquent\Collection;

class RotaSlots
{


    private $rotaSlots;

    private $rotaSlotsByStaffId;

    private $rotaSlotsByDay;

    public function __construct()
    {
        $this->setAllByStaffIdAndShift();
    }

    /**
     * Rearrange rotaSlotsByStaffId for a datatable display and return
     * @return Collection
     */
    public function getRotaSlotShiftList()
    {

        $this->setRotaSlotsByStaffId();

        $rotaSlotList = new Collection();

        foreach ($this->rotaSlotsByStaffId as $staffId => $rotaSlotsByDay) {

            $shift['staffId'] = $staffId;
            foreach ($rotaSlotsByDay as $day => $rotaSlot) {

                if (is_array($rotaSlot)) {
                    $shift[$day] = $rotaSlot['startTime']->format('H:i') . ' - ' . $rotaSlot['endTime']->format('H:i');
                } else {
                    $shift[$day] = '';
                }

            }

            $rotaSlotList->push($shift);
        }

        return $rotaSlotList;
    }


    /**
     * Calculate total work hours by day and returns the array
     *
     * @return array
     */
    public function getTotalWorkHrsByDay()
    {
        $this->setRotaSlotsByDay();

        $totalWorkHoursByDay = [];

        foreach ($this->rotaSlotsByDay as $dayNumber => $rotaSlotsByStaffId) {

            $totalWorkHours = 0;

            foreach ($rotaSlotsByStaffId as $rotaSlot) {
                $totalWorkHours += $rotaSlot['workHours'];
            }

            $totalWorkHoursByDay[$dayNumber] = $totalWorkHours;
        }

        return $totalWorkHoursByDay;

    }


    /**
     * calculate non overlap work hours by day using nonOverlapTimeCalculator and returns the array
     * @return array
     */
    public function getTotalNonOverlapWorkHrsByDay()
    {

        $this->setRotaSlotsByDay();

        $nonOverlapWorkHoursByDay = [];

        foreach ($this->rotaSlotsByDay as $day => $rotaSlotList) {
            $nonOverlapTimeCalculator = new NonOverlapTimeCalculator($rotaSlotList);
            $nonOverlapWorkHoursByDay[$day] = $nonOverlapTimeCalculator->getTotalNonOverlapTime();
        }

        return $nonOverlapWorkHoursByDay;

    }


    /**
     * This method find all rotaslots for slot type 'shift' and non null staffid
     * and set the details to the object variables rotaSlotsByStaffId and rotaSlotsListByDay
     */
    public function setAllByStaffIdAndShift()
    {

        $this->rotaSlots = RotaSlotStaff::orWhereNotNull('staffid')
            ->where('slottype', '=', 'shift')
            ->select('staffid', 'daynumber', 'starttime', 'endtime', 'workhours')
            ->orderBy('staffid')
            ->orderBy('starttime')
            ->orderBy('daynumber')
            ->get();

    }

    /**
     * @return mixed
     */
    public function getAllByStaffIdAndShift()
    {

        return $this->rotaSlots;

    }


    /**
    * get the values from rotaSlots and set the variable rotaSlotsByStaffId
    */
    private function setRotaSlotsByStaffId()
    {

        $this->setRotaSlotsByStaffIdAndDay();
        $this->fillEmptyDayShiftsToNull();

    }


    /**
     * get the values from rotaSlots and set the variable rotaSlotsByDay if its not set before
     *
     * Sort the rotaSlots by day
     */
    private function setRotaSlotsByDay()
    {
        if (!isset($this->rotaSlotsByDay)) {

            $this->setRotaSlotsByStaffIdAndDay();
            ksort($this->rotaSlotsByDay);

        }
    }


    /**
     * Using the $rotaslots set the new rotaSlots by staffId and dayNumber
     */
    private function setRotaSlotsByStaffIdAndDay()
    {

        $this->rotaSlotsByStaffId = [];
        $this->rotaSlotsByDay = [];

        foreach ($this->rotaSlots as $rotaSlot) {

            $dayNumber = $rotaSlot->daynumber;
            $staffId = $rotaSlot->staffid;
            $startTime = $rotaSlot->starttime;
            $endTime = $rotaSlot->endtime;
            $workHours = $rotaSlot->workhours;

            $this->rotaSlotsByStaffId[$staffId][$dayNumber] = compact("startTime", "endTime", "workHours");

            $this->rotaSlotsByDay[$dayNumber][$staffId] = compact("startTime", "endTime", "workHours");

        }



    }


    /**
     * Fill the empty day shifts to null and sort by day
     */
    private function fillEmptyDayShiftsToNull()
    {

        $weekDays = 7;

        foreach ($this->rotaSlotsByStaffId as $staffId => $rotaslotsByDay) {

            for ($day = 0; $day < $weekDays; $day++) {
                if (!array_key_exists($day, $rotaslotsByDay)) {
                    $this->rotaSlotsByStaffId[$staffId][$day] = Null;
                }
            }

            ksort($this->rotaSlotsByStaffId[$staffId]);
        }
    }


}