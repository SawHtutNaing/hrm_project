<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRecords extends Model
{
    protected $fillable = [
        'user_id',
        'check_in_location',
        'check_in_time',
        'check_out_time',
        'check_out_location',
        'date',
        'note',
        'hours_worked',
    ];

    protected $casts = [
        // 'check_in_time' => 'datetime: H:i',
        // 'check_out_time' => 'datetime: H:i',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
