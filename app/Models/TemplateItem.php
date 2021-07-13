<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateItem extends Model
{
    use SoftDeletes;

    protected $table    = 'template_item';

    protected $hidden   = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['region', 'first', 'first_fee', 'additional', 'additional_fee'];

    public function getFirstFeeAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setFirstFeeAttribute(float $value)
    {
        $this->attributes['first_fee'] = bcmul($value, 100);
    }

    public function getAdditionalFeeAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setAdditionalFeeAttribute(float $value)
    {
        $this->attributes['additional_fee'] = bcmul($value, 100);
    }
}
