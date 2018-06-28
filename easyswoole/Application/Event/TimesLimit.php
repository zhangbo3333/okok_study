<?php

namespace App\Event;

use EasySwoole\Core\Component\Pool\PoolManager;
use EasySwoole\Config;
use EasySwoole\Core\AbstractInterface\Singleton;
class TimesLimit {
    use Singleton;
    private  $prefixs = ['email'=>'email.','sms'=>'sms.'];
    private $emailNumber;
    private $smsNumber;
    private $emailCycle;
    private $smsCycle;
    public function __construct()
    {
        $this->initParams();
    }

    public function incr($address,$type)
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        if($redis->exists($this->getPrefix($type).$address)){
            $num = $redis->get($this->getPrefix($type).$address);
            $redis->set($this->getPrefix($type).$address,$num+1);
        }else{
            $redis->setex($this->getPrefix($type).$address,$this->getCycle($type),1);
        }
        unset($redis);
//        $redis = $pool->getObj();
//        $num = $redis->exec('get',self::PREFIX['number'].$this->phone);
//        $redis->exec('set',self::PREFIX['number'].$this->phone,$num+1);
//        $pool->freeObj($redis);

    }
    public function getPrefix($type)
    {
        if($type == 1){
            return $this->prefixs['email'];
        }elseif ($type == 2)
            return $this->prefixs['sms'];
    }

    public function number($address,$type)
    {
        $pool = PoolManager::getInstance()->getPool('App\Utility\RedisPool');
        $redis = $pool->getObj();
        $num = $redis->exec('get',$this->getPrefix($type).$address);

        $pool->freeObj($redis);
        $limit =  $this->getLimit($type);
        if(is_null($num)||$num < $limit){
            return true;
        }
        return false;
    }

    public function initParams()
    {
        $config = Config::getInstance()->getConf('TIMES_LIMIT');
        $this->emailNumber = $config['email']['times'];
        $this->smsNumber = $config['email']['times'];
        $this->emailCycle = $config['sms']['cycle'];
        $this->smsCycle = $config['sms']['cycle'];
    }

    public function getLimit($type)
    {
        if($type == 1)
        {
            return $this->emailNumber;
        }elseif ($type == 2)
        {
            return $this->smsNumber;
        }
    }

    public function getCycle($type)
    {
        if($type == 1)
        {
            return $this->emailCycle;
        }elseif($type ==2)
        {
            return $this->smsCycle;
        }
    }



}