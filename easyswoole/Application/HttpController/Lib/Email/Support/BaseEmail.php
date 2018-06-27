<?php
namespace App\HttpController\Lib\Sms\Support;

use EasySwoole\Core\AbstractInterface\Singleton;
abstract  class BaseEmail {
    use Singleton;

    abstract function send($email,$content);

}