<?php
namespace App\HttpController\Lib\Sms\Support;
use Aws\Ses\SesClient;
use Aws\Sns\SnsClient;
use Aws\Ses\Exception\SesException;
use PHPMailer\PHPMailer\PHPMailer;

class Sms extends BaseSms {
    public function send($phone,$code)
    {
        $snsClient = new SnsClient([
            'region'      => 'us-west-2',//这是亚马逊在新加坡的服务器，具体要根据情况决定
            'credentials' => [
                'key'         => 'AKIAJRQRODSCCHW26LGQ',
                'secret'      => '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',
            ],
            'version'     => 'latest',    //一般在aws的官方api中会有关于这个插件的版本信息
            'debug'       => false,
        ]);

//        $topic = $client->createTopic([
//            'Name' => 'abc'             //自定义
//        ]);                             //如果已经存在一个同名的topic，则不会重新创建
        $args = [
            'Message' => 'Hello, world!',           // REQUIRED
            'PhoneNumber' => '+8618656560190',
        ];
        $snsClient->Publish($args);
    }
}