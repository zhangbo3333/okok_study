<?php

namespace App\Event;

use EasySwoole\Core\Component\Pool\PoolManager;
use EasySwoole\Config;
use EasySwoole\Core\AbstractInterface\Singleton;
class TimesLimit {
    use Singleton;
    private  $prefixs = ['email'=>'email.','sms'=>'sms.'];
    private $workFor;
    private $address;
    private $number;
    private $cycle;

    public function __construct($address,$type)
    {
        $this->address = $address;
        if($type == 1)
        {
            $this->workFor = 'email';
        }elseif ($type == 2)
        {
            $this->workFor = 'sms';
        }
    }

    public function incr()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        if($redis->exists($this->getPrefix().$this->address)){
            $num = $redis->get($this->getPrefix().$this->address);
            $redis->set($this->getPrefix().$this->address,$num+1);
        }else{
            $redis->setex($this->getPrefix().$this->address,$this->cycle,1);
        }
        unset($redis);
//        $redis = $pool->getObj();
//        $num = $redis->exec('get',self::PREFIX['number'].$this->phone);
//        $redis->exec('set',self::PREFIX['number'].$this->phone,$num+1);
//        $pool->freeObj($redis);

    }
    public function getPrefix()
    {
        return $this->prefixs[$this->workFor];
    }

    public function number()
    {
        $pool = PoolManager::getInstance()->getPool('App\Utility\RedisPool');
        $redis = $pool->getObj();
        $num = $redis->exec('get',$this->getPrefix().$this->address);
        var_dump($this->getPrefix().$this->address);
        var_dump($num);
        $pool->freeObj($redis);
        if(is_null($num)||$num < $this->number){
            return true;
        }
        return false;
    }

    public function initParams()
    {
        $config = Config::getInstance()->getConf('TIMES_LIMIT');
        $this->number = $config[$this->workFor]['times'];
        $this->cycle = $config[$this->workFor]['cycle'];
    }



}