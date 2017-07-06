<?php

namespace App\Http\Controllers;

use App\Repositories\RotaSlots;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class RotaSlotStaffController  extends Controller
{

    /**
     * Process Initial request
     * @param RotaSlots $rotaSlots
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(RotaSlots $rotaSlots)
    {

        $totalHoursByDay = $rotaSlots->getTotalWorkHrsByDay();
        $totalNonOverlapHoursByDay = $rotaSlots->getTotalNonOverlapWorkHrsByDay();

        return view('rotaslots.index', compact("totalHoursByDay", "totalNonOverlapHoursByDay"));

    }


    /**
     * Process datatables ajax request.
     * @param RotaSlots $rotaSlots
     * @return mixed
     */
    public function getData(RotaSlots $rotaSlots)
    {

        return Datatables::of($rotaSlots->getRotaSlotShiftList())->make(true);

    }

}
