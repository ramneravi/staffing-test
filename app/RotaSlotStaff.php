<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RotaSlotStaff
 *
 * @property int $id
 * @property int $rotaid
 * @property int $daynumber
 * @property int $staffid
 * @property string $slottype
 * @property \Carbon\Carbon $starttime
 * @property \Carbon\Carbon $endtime
 * @property float $workhours
 * @property int $premiumminutes
 * @property int $roletypeid
 * @property int $freeminutes
 * @property int $seniorcashierminutes
 * @property string $splitshifttimes
 *
 * @package App
 */

class RotaSlotStaff extends Model
{
    protected $table = 'rota_slot_staff';
    public $timestamps = false;

    protected $casts = [
        'rotaid' => 'int',
        'daynumber' => 'int',
        'staffid' => 'int',
        'workhours' => 'float',
        'premiumminutes' => 'int',
        'roletypeid' => 'int',
        'freeminutes' => 'int',
        'seniorcashierminutes' => 'int'
    ];

    protected $dateFormat = 'H:i:s';

    protected $dates = [
        'starttime',
        'endtime'
    ];

    protected $guarded = [];
}
