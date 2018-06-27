<?php


namespace App\HttpController\Lib\Email\Support;

class Aws extends BaseEmail
{
    public  function send($email, $content)
    {
      return ['server_provider'=>'aws','result'=>'ok'];
    }
}