<?php
/**
 * Created by PhpStorm.
 * User: windrunner414
 * Date: 3/18/18
 * Time: 12:44 PM
 */

namespace App\Utility;
use EasySwoole\Config;
use EasySwoole\Core\Component\Pool\AbstractInterface\Pool;
use EasySwoole\Core\Swoole\Coroutine\Client\Redis;

class RedisPool extends Pool
{

    public function getObj($timeOut = 0.1):?Redis
    {
        return parent::getObj($timeOut); // TODO: Change the autogenerated stub
    }

    protected function createObject()
    {
        $conf = Config::getInstance()->getConf('REDIS');
        $redis = new Redis($conf['host'], $conf['port'], $conf['serialize'], $conf['auth']);
        if (is_callable($conf['errorHandler'])) {
            $redis->setErrorHandler($conf['errorHandler']);
        }
        try {
            $redis->exec('select', $conf['dbName']);
        } catch (\Exception $e) {

        }
        return $redis;
    }
}
