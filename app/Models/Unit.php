<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;

    protected $table    = 'unit';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['unit_name', 'sort'];
}
