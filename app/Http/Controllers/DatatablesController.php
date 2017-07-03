<?php

namespace App\Http\Controllers;

use App\Repositories\RotaSlots;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class DatatablesController  extends Controller
{


    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function getIndex(RotaSlots $rotaSlots)
    {
        $rotaSlots->findAllByStaffIdAndShift();
        $totalHoursByDay = $rotaSlots->calculateTotalWorkHrsByDay();
        $totalNonOverlapHoursByDay = $rotaSlots->calculateTotalNonOverlapWorkHrsByDay();

        return view('datatables.index', compact("totalHoursByDay", "totalNonOverlapHoursByDay"));

    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData(RotaSlots $rotaSlots)
    {
       // return Datatables::of(RotaSlotStaff::query())->make(true);
        $rotaSlots->findAllByStaffIdAndShift();

        return Datatables::of($rotaSlots->getRotaSlotShiftList())->make(true);
    }

}
