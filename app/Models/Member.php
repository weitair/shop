<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;

    protected $table      = 'member';

    protected $hidden     = ['password', 'created_at', 'updated_at', 'deleted_at'];

    protected $appends    = ['gender_text', 'channel_text'];

    protected $attributes = ['gender' => 0, 'channel' => 0, 'nickname' => '', 'avatar' => ''];

    protected $guarded    = ['password'];

    // 是否分销商(0：否、1：是)
    const FENXIAO_OFF = 0;
    const FENXIAO_ON  = 1;

    public function getNicknameAttribute(string $value)
    {
        if (empty($value)) {
            $phone = $this->getAttribute('phone');
            $value = substr($phone, 0, 3) . '****' . substr($phone, 7);
        }
        return $value;
    }

    public function getAvatarAttribute(string $value)
    {
        if (empty($value)) {
            return config('app.url') . '/assets/images/avatar.jpg';
        } else {
            if (strpos($value, 'http') === false) {
                $path = config('filesystems.disks.image.path');
                return config('app.url') . $path . $value;
            }
        }
        return $value;
    }

    public function getBirthdayAttribute(int $value)
    {
        return $value ? date("Y-m-d", $value) : '';
    }

    public function setBirthdayAttribute(string $value)
    {
        $this->attributes['birthday'] = strtotime($value);
    }

    public function getRegisterTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getLastLoginTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getChannelTextAttribute()
    {
        if (array_key_exists('channel', $this->attributes)) {
            $status = [
                self::CHANNEL_WECHAT     => '公众号',
                self::CHANNEL_WECHAT_APP => '小程序',
                self::CHANNEL_H5         => 'H5',
            ];
            return $status[$this->getAttribute('channel')];
        }
    }

    public function getGenderTextAttribute()
    {
        if (array_key_exists('gender', $this->attributes)) {
            $status = ['未知', '男', '女'];
            return $status[$this->getAttribute('gender')];
        }
    }

    /********************************************
     *                 关联
     ********************************************/

    /**
     * 关联公众号表
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wechat()
    {
        return $this->hasOne(MemberWechat::class);
    }

    /**
     * 关联小程序表
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function weapp()
    {
        return $this->hasOne(MemberWeapp::class);
    }

    /**
     * 关联邀请人
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function invite()
    {
        return $this->belongsTo(Member::class, 'invite_id');
    }

    /**
     * 关联用户地址
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function address()
    {
        return $this->hasMany(MemberAddress::class);
    }

    /**
     * 关联发票信息
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice()
    {
        return $this->hasOne(MemberInvoice::class);
    }

    /**
     * 关联购物车
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * 关联用户订单
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * 关联用户积分明细
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function point()
    {
        return $this->hasMany(Point::class);
    }

    /**
     * 关联用户成长值明细
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function growth()
    {
        return $this->hasMany(Growth::class);
    }

    /**
     * 关联用户评论
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comment()
    {
        return $this->hasMany(OrderComment::class);
    }

    /**
     * 关联支付表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * 关联标签表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tag()
    {
        return $this->belongsToMany(
            MemberTag::class,
            'member_tag_pivot',
            'member_id',
            'tag_id'
        );
    }

    /**
     * 关联收藏夹
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorite()
    {
        return $this->hasMany(GoodsFavorite::class);
    }

    /**
     * 关联历史
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function history()
    {
        return $this->hasMany(GoodsHistory::class);
    }

    /**
     * 反向关联用户等级
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level()
    {
        return $this->belongsTo(MemberLevel::class, 'level_id');
    }

    /**
     * 关联到优惠卷
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function coupon()
    {
        return $this->hasMany(\Addon\Coupon\Logics\Api\CouponReceive::class);
    }

    /**
     * 获取所有新用户 (未下单的用户)
     * @return mixed
     */
    public static function news()
    {
        return self::whereDoesntHave('order', function (Builder $query) {
            $query->where('payment_status', Order::PAYMENT_STATUS_FINISHED);
        }, '>', 0)->get();
    }

    /**
     * 获取所有老用户
     * @return mixed
     */
    public static function olds()
    {
        return self::whereHas('order', function (Builder $query) {
            $query->where('payment_status', Order::PAYMENT_STATUS_FINISHED);
        }, '>', 0)->get();
    }
}
