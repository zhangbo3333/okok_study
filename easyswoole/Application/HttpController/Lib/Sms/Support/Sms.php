<?php
namespace App\HttpController\Lib\Sms\Support;
use Aws\Ses\SesClient;
use Aws\Sns\SnsClient;


class Sms extends BaseSms {
    public function send($phone,$code)
    {

        //todo   send sms
        $snsClient = new SesClient([
            'region'      => 'us-west-2',//这是亚马逊在新加坡的服务器，具体要根据情况决定
            'credentials' => [
                'key'         => 'AKIAJE353SOUXYK5P4UA',
                'secret'      => 'AhTf8eokqpm+buQszf7Fa80/33bJbqLMUWm2NRwKzM3f',
            ],
            'version'     => '2010-12-01',    //一般在aws的官方api中会有关于这个插件的版本信息
            'debug'       => false,
        ]);

////        $topic = $snsClient->createTopic([
////            'Name' => 'abc'             //自定义
////        ]);                             //如果已经存在一个同名的topic，则不会重新创建
//        $args = [
//            'Message' => 'Hello, world!',           // REQUIRED
//            'PhoneNumber' => '+8618656560190',
//        ];
//        $res = $snsClient->Publish($args);
//        $snsClient->Host= "tls://email-smtp.us-east.amazonaws.com"; // Amazon SES
//        $snsClient->Port = 465;  // SMTP Port
        $result = $snsClient->sendEmail([
            'Destination' => [
//                'BccAddresses' => [
//                ],
//                'CcAddresses' => [
//                    'recipient3@example.com',
//                ],
                'ToAddresses' => [
                    '527837702@qq.com',
                ],
            ],
            'Message' => [
                'Body' => [
                    'Html' => [
                        'Charset' => 'UTF-8',
                        'Data' => 'This message body contains HTML formatting. It can, for example, contain links like this one: Amazon SES Developer Guide.',
                    ],
                    'Text' => [
                        'Charset' => 'UTF-8',
                        'Data' => 'This is the message body in text format.',
                    ],
                ],
                'Subject' => [
                    'Charset' => 'UTF-8',
                    'Data' => 'Test email',
                ],
            ],
            'ReplyToAddresses' => [
            ],
            'ReturnPath' => '',
            'ReturnPathArn' => '',
            'Source' => 'sender@example.com',
            'SourceArn' => '',
        ]);
//        var_dump(1);
        var_dump($result);
//        var_dump(2);
        return ['phone'=>$phone,'code'=>$code,'provider'=>'aws','result'=>'ok'];
    }
}