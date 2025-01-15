<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'nick_name', 'division_type_id'];

    public function divisionType()
    {
        return $this->belongsTo(DivisionType::class);
    }
}
