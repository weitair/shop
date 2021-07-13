<?php

namespace App\Models;

class Role extends Model
{
    protected $table    = 'role';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['role_name', 'intro'];

    public function roleModule()
    {
        return $this->hasMany(RoleModule::class);
    }

    public function module()
    {
        return $this->belongsToMany(Module::class, 'role_module')
            ->orderBy('sort', 'asc');
    }
}
