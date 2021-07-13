<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class MemberAddress extends Model
{
    use SoftDeletes;

    protected $table      = 'member_address';

    protected $hidden     = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends    = ['default_text', 'label_text', 'type_text', 'gender_text'];

    protected $attributes = ['default' => 0, 'label' => 0, 'type' => 0, 'gender' => 1];

    protected $guarded    = ['member_id'];

    // 是否默认地址(0：否、1：是)
    const DEFAULT_OFF = 0;
    const DEFAULT_ON  = 1;

    // 地址标签(0：家、1：公司、2：学校、3：其他)
    const LABEL_HOME    = 0;
    const LABEL_COMPANY = 1;
    const LABEL_SCHOOL  = 2;
    const LABEL_OTHER   = 3;

    // 地址类型(0：快递配送，1：同城配送)
    const TYPE_EXPRESS = 0;
    const TYPE_LOCAL   = 1;

    // 性别(1：男、2：女 )
    const GENDER_SECRET = 0;
    const GENDER_MAN    = 1;
    const GENDER_WOMEN  = 2;

    public function getDefaultTextAttribute()
    {
        $status = [
            self::DEFAULT_OFF => '否',
            self::DEFAULT_ON  => '是',
        ];
        return $status[$this->getAttribute('default')];
    }

    public function getTypeTextAttribute()
    {
        $status = [
            self::TYPE_EXPRESS => '快递配送',
            self::TYPE_LOCAL   => '同城配送',
        ];
        return $status[$this->getAttribute('type')];
    }

    public function getLabelTextAttribute()
    {
        $status = [
            self::LABEL_HOME     => '家',
            self::LABEL_COMPANY  => '公司',
            self::LABEL_SCHOOL   => '学校',
            self::LABEL_OTHER    => '其他'
        ];
        return $status[$this->getAttribute('label')];
    }

    public function getGenderTextAttribute()
    {
        $status = [
            self::GENDER_SECRET => '保密',
            self::GENDER_MAN    => '先生',
            self::GENDER_WOMEN  => '女士',
        ];
        return $status[$this->getAttribute('gender')];
    }

    /**
     * 关联
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
