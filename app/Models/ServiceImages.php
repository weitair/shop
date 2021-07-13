<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceImages extends Model
{
    use SoftDeletes;

    protected $table    = 'service_images';

    protected $hidden   = [];

    protected $guarded = ['service_id'];
}