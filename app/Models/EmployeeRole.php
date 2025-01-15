<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeRole extends Model
{
    protected $fillable = ['name', 'sort_no', 'payscale_id'];

    protected $table = 'employee_roles';

    public function payscale()
    {
        return $this->belongsTo(Payscale::class);
    }
}
