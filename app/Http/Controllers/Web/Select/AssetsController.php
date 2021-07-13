<?php

namespace App\Http\Controllers\Web\Select;

use App\Http\Controllers\Web\Controller;
use App\Logics\Web\Select;
use App\Services\Storage\Factory;

class AssetsController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            [
                'group' => Select::assetsGrouopList(),
                'list'  => Select::assetsList()
            ]
        );
    }

    public function list()
    {
        $this->renderSuccess(Select::assetsList());
    }

    public function moveSubmit()
    {
        $this->validate([
            'id'       => 'required|string',
            'group_id' => 'required|int',
        ]);

        $id       = $this->request->post('id');
        $group_id = $this->request->post('group_id');
        if (Select::assetsMove($group_id, $id) === true) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function removeSubmit()
    {
        $this->validate([
            'id' => 'required|string'
        ]);

        if (Select::assetsRemove($this->request->post('id'))) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function groupAddSubmit()
    {
        $this->validate([
            'group_name' => 'required|string',
        ]);

        if (Select::assetsGroupAdd($this->request->all())) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function uploadSubmit()
    {
        $action   = 'image';
        $storage  = Factory::getInstance($action);
        $group_id = $this->request->post('group_id', 0);

        if ($storage->upload()) {
            if (strpos($file['file'] = $storage->getFileName(), 'http') === false) {
                $path = config("filesystems.disks.$action.path") . $file['file'];
                $file['file'] = config('app.url') . $path;
            }
            $file['size'] = $storage->getFileSize();
            $file['type'] = $storage->getMimeType();
            $file['name'] = $storage->getOriginalName();

            if (Select::assetsUpload($group_id, $file)) {
                $this->renderSuccess([], '上传成功');
            }
        }
        $this->renderError([], '上传失败');
    }

    public function remoteSubmit()
    {
        $this->validate([
            'group_id'   => 'required|int',
            'image_link' => 'required|string',
        ]);

        if ($file = Select::assetsRemote($this->request->post())) {
            $this->renderSuccess(['file' => $file], '上传成功');
        }
        $this->renderError([], '上传失败');
    }
}
