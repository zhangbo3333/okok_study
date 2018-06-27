<?php
namespace App\HttpController\Lib\Sms\Support;

use EasySwoole\Core\AbstractInterface\Singleton;
abstract  class BaseSms {
    use Singleton;

    abstract function send($phone,$code);


}