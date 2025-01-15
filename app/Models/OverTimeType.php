<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverTimeType extends Model
{
    /** @use HasFactory<\Database\Factories\OverTimeTypeFactory> */
    use HasFactory;

    protected $fillable = ['name'];
}
