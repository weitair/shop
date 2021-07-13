<?php

namespace App\Services\Poster\Engine;

use App\Logics\Api\Goods as GoodsLogic;
use Intervention\Image\Facades\Image;
use App\Exceptions\AppException;
use App\Logics\Api\Member;
use Log;
use Str;

class Goods extends Server
{
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function make(string $qrcode, GoodsLogic $goods, array $setting, Member $member = null)
    {
        try {
            $title        = $setting['title'];
            $color        = $setting['color'];
            $goods_image  = $goods->images[0]['name'];
            $goods_name   = $goods->goods_name;
            $sales_price  = $goods->sales_price;
            $line_price   = $goods->line_price;

            $goods_image  = Image::make($goods_image)->resize(600, 600);
            $qrcode       = Image::make($qrcode)->resize(200, 200);
            // 处理字符换行
            $goods_name   = Str::limit($goods_name, 32);
            $goods_name   = $this->wrap($goods_name, 42, 500);

            $image = $this->background
                // 中央白图区域
                ->rectangle(40, 150, 710, 1160, function ($draw) {
                    $draw->background('#fff');
                })
                ->insert($goods_image, 'top', 0, 180)
                ->insert($qrcode, 'bottom-right', 70, 80)
                ->text("￥$sales_price", 80, 860, function ($font) {
                    $font->file($this->fontFamily);
                    $font->size(48);
                    $font->color('#ee0a24');
                })
                ->text("原价:￥$line_price", 80, 900, function ($font) {
                    $font->file($this->fontFamily);
                    $font->size(28);
                    $font->color('#999999');
                })
                ->text($goods_name, 80, 1000, function ($font) {
                    $font->file($this->fontFamily);
                    $font->size(38);
                    $font->color('#353535');
                })
                ->text("长按图片，立即购买", 210, 1120, function ($font) {
                    $font->file($this->fontFamily);
                    $font->size(28);
                    $font->align('center');
                    $font->color('#999999');
                });

            $nickname = '你的朋友';
            $avatar   = '';
            $offset   = 60;
            if (!empty($member)) {
                $nickname = $member->nickname;
                $avatar   = $member->avatar;
            }
            if (!empty($avatar)) {
                $offset = 150;
                $avatar = Image::make($avatar)->resize(80, 80);
                $avatar = $this->round($avatar, 100);
                $image->insert($avatar, 'top-left', 50, 50);
            }

            $image->text($nickname, $offset, 80, function ($font) use ($color) {
                $font->file($this->fontFamily);
                $font->size(32);
                $font->color($color);
            })->text($title, $offset, 120, function ($font) use ($color) {
                $font->file($this->fontFamily);
                $font->size(24);
                $font->color($color);
            });
            return $image->encode('jpg')->encode('data-url')->encoded;
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            throw new AppException('海报生成失败');
        }
    }
}
