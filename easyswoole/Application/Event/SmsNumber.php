<?php

namespace App\Event;

use EasySwoole\Core\Component\Pool\PoolManager;

class SmsNumber {

    const   PREFIX = ['number'=>'number.'];
    private $checkType = ['number'];
    private $phone;
    private $day = 0;
    private $oneDaySec = 86400;
    private $expire;
    private $number = 5;

    public function __construct($phone)
    {

        $this->phone = $phone;
        $this->initTime();

    }
    public function initTime()
    {
        $endTime = strtotime(date('Y-m-d'). ' 23:59:59') + $this->oneDaySec * $this->day;
        $this->expire  = $endTime - time();
    }

    public function incr()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        if($redis->exists(self::PREFIX['number'].$this->phone)){
            $num = $redis->get(self::PREFIX['number'].$this->phone);
            $redis->set(self::PREFIX['number'].$this->phone,$num+1);
        }else{
            $redis->setex(self::PREFIX['number'].$this->phone,$this->expire,1);
        }
        unset($redis);
//        $redis = $pool->getObj();
//        $num = $redis->exec('get',self::PREFIX['number'].$this->phone);
//        $redis->exec('set',self::PREFIX['number'].$this->phone,$num+1);
//        $pool->freeObj($redis);

    }

    public function number()
    {

        $pool = PoolManager::getInstance()->getPool('App\Utility\RedisPool');
        $redis = $pool->getObj();
        $num = $redis->exec('get',self::PREFIX['number'].$this->phone);
        $pool->freeObj($redis);
        if(is_null($num)||$num < $this->number){
            return true;
        }
        return false;
    }

    public function check()
    {
        foreach($this->checkType as $v){
            if(!$this->$v()){
                return false;
            }
        }
        return true;
    }



}