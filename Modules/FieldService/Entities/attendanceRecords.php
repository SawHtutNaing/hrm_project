<?php

namespace Modules\FieldService\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendanceRecords extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    public $table = 'attendance_records';

    public $timestamps = false;

    protected $fillable = [
        'campaign_id',
        'employee_id',
        'location_name',
        'gps_location',
        'checkin_datetime',
        'checkout_datetime',
        'checkout_gps_location',
        'checkout_location_name',
        'hours_worked', 'status', 'photo',
    ];
}
