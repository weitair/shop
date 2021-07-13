<?php

namespace App\Http\Controllers\Web;

use App\Services\Storage\Factory;

class UploadController extends Controller
{
    public function index(string $action = '', int $width = 0, int $height = 0)
    {
        $storage = Factory::getInstance($action);

        if (empty($width) && empty($height)) {
            $result = $storage->upload();
        } else {
            $result = $storage->uploadAndResize($width, $height);
        }

        if ($result) {
            if (strpos($file = $storage->getFileName(), 'http') === false) {
                $path = config('filesystems.disks.' . $action . '.path') . $file;
                $file = config('app.url') . $path;
            }
            $this->renderSuccess(['file' => $file], '上传成功');
        }
        $this->renderError([], '上传失败');
    }
}
