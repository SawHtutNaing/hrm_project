<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    public function morphable()
    {
        return $this->morphTo();
    }
}
