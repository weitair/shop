<?php

namespace App\Services\Poster\Engine;

use Intervention\Image\Facades\Image;

abstract class Server
{
    protected $config;

    protected $background;

    protected $fontFamily;

    protected function __construct(array $config = [])
    {
        $this->config     = $config;
        $this->fontFamily = public_path() . '/fonts/Alibaba-PuHuiTi-Regular.ttf';
        $this->background();
    }

    private function background()
    {
        $background       = isset($this->config['background']) ? $this->config['background'] : '#fff';
        $this->background = Image::canvas($this->config['width'], $this->config['height'], $background);
    }

    /**
     * @param string $content 内容
     * @param int $fontSize 字体大小
     * @param int $width 宽度
     * @return string
     */
    protected function wrap(string $content, int $fontSize, int $width)
    {
        $result = "";
        // 将字符串拆分成一个个单字 保存到数组 letter 中
        preg_match_all("/./u", $content, $array);
        $letter = $array[0];

        foreach ($letter as $char) {
            $string = $result . $char;
            $box    = imagettfbbox($fontSize, 0, $this->fontFamily, $string);
            if (($box[2] > $width) && ($content !== "")) {
                $result .= PHP_EOL;
            }
            $result .= $char;
        }
        return $result;
    }

    protected function round($image, int $size)
    {
        $result = Image::canvas($size, $size);
        $width  = $image->width() / 2;

        for ($x = 0; $x < $image->width(); $x++) {
            for ($y = 0; $y < $image->height(); $y++) {
                $c = $image->pickColor($x, $y, 'array');
                if (((($x - $width) * ($x - $width) + ($y - $width) * ($y - $width)) < ($width * $width))) {
                    $result->pixel($c, $x, $y);
                }
            }
        }
        return $result;
    }
}
