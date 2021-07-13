<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceCategory extends Model
{
    use SoftDeletes;

    protected $table    = 'service_category';

    protected $hidden   = [];

    protected $fillable = ['category_name', 'sort', 'status'];

    // 状态(0：禁用、1：启用)
    const STATUS_OFF = 0;
    const STATUS_ON  = 1;
}
