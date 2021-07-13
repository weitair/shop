<?php

namespace Addon\Install\Models;

use Addon\Install\Events\InstallEvent;
use App\Exceptions\AppException;
use App\Models\Model;
use Event;
use File;
use Log;

class Install extends Model
{
    public static function submit(array $params)
    {
        try {
            // mysql
            $dbhost     = $params['dbhost'];
            $dbport     = $params['dbport'];
            $dbname     = $params['dbname'];
            $dbuser     = $params['dbuser'];
            $dbpassword = $params['dbpassword'];

            // redis
            $redishost     = $params['redishost'];
            $redisport     = $params['redisport'];
            $redispassword = empty($params['redispassword']) ? 'null' : $params['redispassword'];

            $connect = mysqli_connect($dbhost, $dbuser, $dbpassword, '', $dbport);

            // 数据库存在的话，删除
            if (mysqli_select_db($connect, $dbname)) {
                if (!mysqli_query($connect, 'DROP DATABASE ' . $dbname)) {
                    throw new AppException('删除除库失败');
                }
            }

            // 创建数据库
            $create = mysqli_query($connect,
                'CREATE DATABASE ' . $dbname . ' DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_general_ci');
            if (!$create) throw new AppException('创建数据库失败');

            // 导入数据
            mysqli_select_db($connect, $dbname);
            mysqli_query($connect, "SET NAMES utf8mb4");
            $sql = File::get(module_path('Install') . '/Database/database.sql');

            preg_match_all("/Create table .*\(.*\).*\;/iUs", $sql, $list);
            foreach ($list[0] as $item) {
                mysqli_query($connect, $item);
            }

            preg_match_all("/INSERT INTO .*\(.*\).*\;/iUs", $sql, $list);
            foreach ($list[0] as $item) {
                mysqli_query($connect, $item);
            }
            // 关闭数据库连接
            mysqli_close($connect);

            /**
             * 数据库初始化完成
             */
            $root   = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];
            $ip     = $_SERVER['SERVER_ADDR'];
            $secret = md5($root . $ip . time());

            // 修改配置文件
            $env_path = base_path('.env');
            if (!File::isWritable($env_path)) throw new AppException('配置文件不可写');

            $env  = "APP_URL=$root" . PHP_EOL;
            $env .= "DB_CONNECTION=mysql" . PHP_EOL;
            $env .= "DB_HOST=$dbhost" . PHP_EOL;
            $env .= "DB_PORT=$dbport" . PHP_EOL;
            $env .= "DB_DATABASE=$dbname" . PHP_EOL;
            $env .= "DB_USERNAME=$dbuser" . PHP_EOL;
            $env .= "DB_PASSWORD=$dbpassword" . PHP_EOL;
            $env .= "DB_PREFIX=weitair_" . PHP_EOL;
            $env .= "REDIS_HOST=$redishost" . PHP_EOL;
            $env .= "REDIS_PORT=$redisport" . PHP_EOL;
            $env .= "REDIS_PASSWORD=$redispassword" . PHP_EOL;
            $env .= "BROADCAST_DRIVER=log" . PHP_EOL;
            $env .= "CACHE_DRIVER=redis" . PHP_EOL;
            $env .= "QUEUE_CONNECTION=database" . PHP_EOL;
            $env .= "LOG_CHANNEL=daily" . PHP_EOL;
            $env .= "LOG_LEVEL=debug" . PHP_EOL;
            $env .= "LOG_DAYS=30" . PHP_EOL;

            if (File::put($env_path, $env)) {
                \Artisan::call('config:clear');
                \Artisan::call('config:cache');

                File::put(base_path('secret.key'), $secret);

                $params['root']   = $root;
                $params['secret'] = $secret;
                Event::dispatch(new InstallEvent($params));

                // 生成install.lock
                File::put(base_path('install.lock'), 'installed at ' . date("Y-m-d H:i:s", time()));
                return true;
            }
            return false;
        } catch(AppException $e) {
            throw new AppException($e->getMessage());
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }
}
