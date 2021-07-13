<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class AssetsGroup extends Model
{
    use SoftDeletes;

    protected $table    = 'assets_group';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['group_name', 'sort'];

    public function assets()
    {
        return $this->hasMany(Assets::class);
    }
}
