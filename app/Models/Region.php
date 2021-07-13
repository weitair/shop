<?php

namespace App\Models;

class Region extends Model
{
    protected $table    = 'region';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'parent_id',
        'name',
        'shortname',
        'lon',
        'lat',
        'level',
        'sort',
        'status',
    ];
}
