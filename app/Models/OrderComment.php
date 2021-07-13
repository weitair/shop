<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class OrderComment extends Model
{
    use SoftDeletes;

    protected $table      = 'order_comment';

    protected $hidden     = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends    = ['satisfaction_text', 'status_text', 'top_status_text'];

    protected $attributes = ['satisfaction' => 0, 'status' => 0, 'top_status' => 0];

    protected $guarded    = ['order_id'];

    // 回复状态(0：待回复、1：已回复)
    const REPLY_STATUS_AWAIT  = 0;
    const REPLY_STATUS_FINISH = 1;

    // 满意度(0：差评、1：中评、2：好评)
    const SATISFACTION_FAIL   = 0;
    const SATISFACTION_MIDDLE = 1;
    const SATISFACTION_PRAISE = 2;

    // 评论置顶(0：否、1：是)
    const TOP_STATUS_OFF = 0;
    const TOP_STATUS_ON  = 1;

    // 状态(0：拒绝、1：通过)
    const STATUS_AWAIT = 0;
    const STATUS_FAIL  = 1;
    const STATUS_PASS  = 2;

    public function getCommentTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getReplyTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getSatisfactionTextAttribute()
    {
        $status = [
            self::SATISFACTION_FAIL   => '差评',
            self::SATISFACTION_MIDDLE => '中评',
            self::SATISFACTION_PRAISE => '好评',
        ];
        return $status[$this->getAttribute('satisfaction')];
    }

    public function getStatusTextAttribute()
    {
        $status = [
            self::STATUS_AWAIT => '待审核',
            self::STATUS_FAIL  => '已拒绝',
            self::STATUS_PASS  => '已通过',
        ];
        return $status[$this->getAttribute('status')];
    }

    public function getTopStatusTextAttribute()
    {
        $status = [
            self::TOP_STATUS_OFF => '否',
            self::TOP_STATUS_ON  => '是',
        ];
        return $status[$this->getAttribute('top_status')];
    }

    /**
     * 关联回复的图片
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(OrderCommentImages::class, 'comment_id');
    }

    /**
     * 反向关联到用户表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * 反向关联到商品表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }

    /**
     * 反向关联到订单表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
