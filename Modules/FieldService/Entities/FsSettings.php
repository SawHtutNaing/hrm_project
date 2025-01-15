<?php

namespace Modules\FieldService\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FsSettings extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    public $timestamps = false;

    protected $table = 'fs_settings';

    protected $fillable = ['key', 'value'];
}
