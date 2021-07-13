<?php

namespace App\Models;

class RoleModule extends Model
{
    protected $table    = 'role_module';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['role_id', 'module_id'];
}
