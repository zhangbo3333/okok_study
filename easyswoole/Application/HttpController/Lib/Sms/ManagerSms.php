<?php


namespace App\HttpController\Lib\Sms;


use EasySwoole\Core\AbstractInterface\Singleton;

class ManagerSms {

    use Singleton;

    public static $SmsName = 'Sms';
    public static $namespace = 'App\HttpController\Lib\Sms\Support\\';

    protected function __construct($SmsName = null)
    {
        if($SmsName != null){
            self::$SmsName = $SmsName;
        }
    }

    public function __call($name,$arg)
    {
        $obj = (self::$namespace.self::$SmsName)::getInstance();
         return $obj->$name(...$arg);
    }
}