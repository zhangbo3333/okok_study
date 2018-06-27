<?php


namespace App\HttpController\Lib\Email\Support;

use App\HttpController\Lib\Sms\Support\BaseEmail;

class Aws extends BaseEmail
{
    public  function send($email, $content)
    {
      return ['data'=>['server_provider'=>'aws','result'=>'ok']];
    }
}