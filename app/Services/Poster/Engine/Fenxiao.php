<?php

namespace App\Services\Poster\Engine;

use Intervention\Image\Facades\Image;
use App\Exceptions\AppException;
use App\Models\Member;
use Log;
use Str;

class Fenxiao extends Server
{
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function make(string $qrcode, string $image, string $title, Member $member = null)
    {
        try {
            $color  = '#353535';
            $image  = Image::make($image)->resize(620, 620);
            $qrcode = Image::make($qrcode)->resize(200, 200);
            // 处理字符换行
            $title = Str::limit($title, 60);
            $title = $this->wrap($title, 42, 550);

            $image = $this->background
                // 中央白图区域
                ->rectangle(40, 150, 710, 1100, function ($draw) {
                    $draw->background('#fff');
                })
                ->insert($image, 'top', 0, 180)
                ->insert($qrcode, 'bottom-right', 70, 100)
                ->text($title, 80, 900, function ($font) use ($color) {
                    $font->file($this->fontFamily);
                    $font->size(38);
                    $font->color($color);
                })
                ->text("长按图片，立即加入", 210, 1080, function ($font) {
                    $font->file($this->fontFamily);
                    $font->size(28);
                    $font->align('center');
                    $font->color('#999999');
                });

            $nickname = $member->nickname;
            $avatar   = $member->avatar;
            $avatar   = Image::make($avatar)->resize(80, 80);
            $avatar   = $this->round($avatar, 100);
            $image->insert($avatar, 'top-left', 50, 50);

            $image->text($nickname, 150, 100, function ($font) use ($color) {
                $font->file($this->fontFamily);
                $font->size(32);
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
