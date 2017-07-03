<?php

namespace App\Http\Controllers;

use App\Repositories\RotaSlots;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class RotaSlotStaffController  extends Controller
{

    /**
     * Displays datatables front end view
     *
     * @return \Illuminate\View\View
     */
    public function index(RotaSlots $rotaSlots)
    {

        $totalHoursByDay = $rotaSlots->getTotalWorkHrsByDay();
        $totalNonOverlapHoursByDay = $rotaSlots->getTotalNonOverlapWorkHrsByDay();

        return view('rotaslots.index', compact("totalHoursByDay", "totalNonOverlapHoursByDay"));

    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData(RotaSlots $rotaSlots)
    {

        return Datatables::of($rotaSlots->getRotaSlotShiftList())->make(true);

    }

}
