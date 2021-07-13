<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Express extends Model
{
    use SoftDeletes;

    protected $table    = 'express';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['company', 'code', 'sort'];
}
