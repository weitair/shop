<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Assets extends Model
{
    use SoftDeletes;

    protected $table   = 'assets';

    protected $hidden  = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['account_id'];

    public function getUploadTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function group()
    {
        return $this->belongsTo(AssetsGroup::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
