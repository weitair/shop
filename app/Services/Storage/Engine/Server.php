<?php

namespace App\Services\Storage\Engine;

use App\Exceptions\AppException;
use Illuminate\Http\Request;

abstract class Server
{
    protected $config;
    protected $file;
    protected $fileName;
    protected $fileSize;
    protected $mimeType;
    protected $originalName;

    protected function __construct(array $config = [])
    {
        $this->config   = $config;
        $this->file     = Request::capture()->file('file');
        $this->fileName = $this->getSaveName();
        $this->fileSize = $this->file->getSize();
        $this->mimeType = $this->file->getMimeType();
        $this->originalName = $this->file->getClientOriginalName();
        $this->validFile();
    }

    abstract protected function upload();

    abstract protected function uploadAndResize(int $width, int $height);

    public function getFileName()
    {
        return $this->fileName;
    }

    public function getFileSize()
    {
        return $this->fileSize;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * 检查文件合法性
     *
     * @throws AppException
     */
    protected function validFile()
    {
        if ($this->file->isValid() === false) {
            throw new AppException('文件上传错误');
        }

        $size = $this->config['size'];
        $type = $this->config['type'];

        if ($size < $this->file->getSize()) {
            throw new AppException('文件大小超过' . ($size / 1024 /1024) . 'MB的限制');
        }
        if (count($type) > 0 && !in_array(strtolower($this->file->getClientOriginalExtension()), $type)) {
            throw new AppException('只能上传' . (strtoupper(implode(',', $type))) . '类型的文件');
        }
    }

    /**
     * 获取文件在服务端保存的文件名
     *
     * @return string
     */
    private function getSaveName()
    {
        $realPath  = $this->file->getRealPath();
        $extension = $this->file->getClientOriginalExtension();
        // 自动生成文件名
        return date('YmdHis')
            . substr(md5($realPath), 0, 5)
            . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT)
            . '.' . $extension;
    }
}
