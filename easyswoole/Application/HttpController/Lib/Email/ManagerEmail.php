<?php

namespace App\HttpController\Lib\Email;

use EasySwoole\Core\AbstractInterface\Singleton;
class  ManagerEmail
{
    use Singleton;

    public static $SmsName = 'Aws';
    public static $namespace = 'App\HttpController\Lib\Email\Support\\';

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