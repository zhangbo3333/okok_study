<?php
namespace App\HttpController\Lib\Email\Support;

use EasySwoole\Core\AbstractInterface\Singleton;
abstract  class BaseEmail {
    use Singleton;

    abstract function send($email,$content);

}