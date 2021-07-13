<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Search extends Model
{
    use SoftDeletes;

    protected $table   = 'search';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [];
}
