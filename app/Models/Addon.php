<?php

namespace App\Models;

class Addon extends Model
{
    protected $table   = 'addon';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['key'];

    public function module()
    {
        return $this->hasOne(Module::class, 'addon_key', 'key');
    }
}
