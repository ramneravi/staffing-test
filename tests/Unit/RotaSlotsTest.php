<?php

namespace Tests\Feature;

use App\Repositories\RotaSlots;
use App\RotaSlotStaff;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RotaSlotsTest extends TestCase
{


    public function setUp()
    {
        parent::setUp();
        RotaSlotStaff::truncate();
    }


    /** @test  */
    public function set_all_by_staff_id_notnull_and_slottype_shift()
    {

        factory(RotaSlotStaff::class, 10)->create(['slottype' => 'shift']);
        factory(RotaSlotStaff::class, 5)->create(['slottype' => 'dayoff']);
        factory(RotaSlotStaff::class, 5)->create(['staffid' => NULL]);

        $rotaSlots = new RotaSlots();
        $rotaSlots->setAllByStaffIdAndShift();
        $this->assertCount(10, $rotaSlots->getAllByStaffIdAndShift());


    }

    /** @test  */
    public function get_rota_slot_shift_list_groupby_staffid()
    {

        factory(RotaSlotStaff::class, 7)->create(['staffid' => '334']);
        factory(RotaSlotStaff::class, 7)->create(['staffid' => '335']);
        factory(RotaSlotStaff::class, 5)->create(['staffid' => NULL]);

        $rotaSlots = new RotaSlots();
        $rotaSlotList = $rotaSlots->getRotaSlotShiftList();
        $this->assertCount(2, $rotaSlotList);
    }

    /** @test  */
    public function get_total_work_hrs_by_day()
    {

        factory(RotaSlotStaff::class, 10)->create([
            'daynumber' => 1,
            'slottype' => 'shift',
            'workhours' => 7.5
        ]);
        factory(RotaSlotStaff::class, 10)->create([
            'daynumber' => 2,
            'slottype' => 'shift',
            'workhours' => 8.5
        ]);
        factory(RotaSlotStaff::class, 2)->create([
            'daynumber' => 3,
            'slottype' => 'dayoff',
            'workhours' => 7.5
        ]);
        factory(RotaSlotStaff::class, 10)->create([
            'daynumber' => 3,
            'slottype' => 'shift',
            'workhours' => 8
        ]);


        $rotaSlots = new RotaSlots();
        $totalWorkHrsByDay = $rotaSlots->getTotalWorkHrsByDay();
        $this->assertEquals(75, $totalWorkHrsByDay[1]);
        $this->assertEquals(85, $totalWorkHrsByDay[2]);
        $this->assertEquals(80, $totalWorkHrsByDay[3]);

    }

    public function tearDown()
    {
        parent::tearDown();
    }
}
