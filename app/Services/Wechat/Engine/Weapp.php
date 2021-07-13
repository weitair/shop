<?php

namespace App\Services\Wechat\Engine;

use App\Exceptions\AppException;
use EasyWeChat\Factory;
use Log;

class Weapp extends Server
{
    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->app = Factory::miniProgram([
            'app_id' => $config['app_id'],
            'secret' => $config['app_secret']
        ]);
    }

    /**
     * 获取手机号
     * @param string $sessionKey
     * @param string $iv
     * @param string $encryptedData
     * @return mixed
     * @throws AppException
     */
    public function getPhone(string $sessionKey, string $iv, string $encryptedData)
    {
        try {
            $result = $this->app->encryptor
                ->decryptData($sessionKey, $iv, urldecode($encryptedData));
            return $result['phoneNumber'];
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            throw new AppException('获取手机号码失败,请重试');
        }
    }

    /**
     * 生成小程序码
     * @param string $scene
     * @param string $page
     * @param int $width
     * @return string
     */
    public function getUnlimit(string $scene, string $page = '', int $width = 280)
    {
        $response = $this->app->app_code->getUnlimit($scene, [
            'page'  => $page,
            'width' => $width,
        ]);
        if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
            return $response->getBody()->getContents();
        }
        return '';
    }

    /**
     * 获取小程序登录用户的session
     * @param string $code
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws AppException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getSession(string $code)
    {
        $result = $this->app->auth->session($code);
        if (isset($result['errcode'])) {
            Log::error(json_encode($result) . PHP_EOL);
            throw new AppException('未获取到微信信息');
        }
        return $result;
    }
}
