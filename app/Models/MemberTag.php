<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class MemberTag extends Model
{
    use SoftDeletes;

    protected $table    = 'member_tag';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['tag_name', 'sort', 'intro'];

    public function member()
    {
        return $this->belongsToMany(
            Member::class,
            'member_tag_pivot',
            'tag_id',
            'member_id'
        );
    }
}
