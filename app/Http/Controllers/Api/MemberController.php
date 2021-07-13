<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Member;
use App\Services\Storage\Factory;

class MemberController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            Member::detail()
        );
    }

    public function avatar()
    {
        $action = 'image';
        $storage = Factory::getInstance($action);

        if ($storage->upload()) {
            if (strpos($file = $storage->getFileName(), 'http') === false) {
                $path = config('filesystems.disks.' . $action . '.path') . $file;
                $file = config('app.url') . $path;
            }
            if (Member::change(['avatar' => $file])) {
                $this->renderSuccess(['file' => $file], '上传成功');
            }
        }
        $this->renderError([], '上传失败');
    }

    public function change()
    {
        if (Member::change($this->request->all())) {
            $this->renderSuccess();
        }
        $this->renderError();
    }
}
