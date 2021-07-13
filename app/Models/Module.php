<?php

namespace App\Models;

class Module extends Model
{
    protected $table    = 'module';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'module_name',
        'parent_id',
        'icon',
        'level',
        'type',
        'server_router',
        'client_router',
        'redirect',
        'extend',
        'hidden',
        'sort',
        'intro'
    ];

    const EXTEND = 1; // 是否权限继承
    const HIDDEN = 1; // 是否隐藏

    public function roleModule()
    {
        return $this->hasMany(RoleModule::class);
    }

    public function addon()
    {
        return $this->belongsTo(Addon::class, 'addon_key', 'key');
    }

//    public function allChildren() {
//        return $this->hasMany(get_class($this), 'parent_id' )->orderBy('sort', 'asc');
//    }
//
//    public function children() {
//        return $this->allChildren()->with( 'children' );
//    }
}
