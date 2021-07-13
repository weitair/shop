<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class WechatFans extends Model
{
    use SoftDeletes;

    protected $table      = 'wechat_fans';

    protected $hidden     = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded    = ['id'];

    protected $appends    = ['sex_text', 'subscribe_scene_text'];

    protected $attributes = ['sex' => 0, 'subscribe_scene' => 0];



    public function getSubscribeTimeAttribute($value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getSexTextAttribute()
    {
        $status = [
            0 => '未知',
            1 => '男',
            2 => '女',
        ];
        return $status[$this->getAttribute('sex')];
    }

    public function getSubscribeSceneTextAttribute()
    {
        $status = [
            'ADD_SCENE_SEARCH'               => '公众号搜索',
            'ADD_SCENE_ACCOUNT_MIGRATION'    => '公众号迁移',
            'ADD_SCENE_PROFILE_CARD'         => '名片分享',
            'ADD_SCENE_QR_CODE'              => '扫描二维码',
            'ADD_SCENE_PROFILE_LINK'         => '图文页内名称点击',
            'ADD_SCENE_PROFILE_ITEM'         => '图文页右上角菜单',
            'ADD_SCENE_PAID'                 => '支付后关注',
            'ADD_SCENE_WECHAT_ADVERTISEMENT' => '微信广告',
            'ADD_SCENE_OTHERS'               => '其他',
        ];
        return $status[$this->getAttribute('subscribe_scene')];
    }
}
