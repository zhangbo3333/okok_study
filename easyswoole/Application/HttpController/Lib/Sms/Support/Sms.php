<?php
namespace App\HttpController\Lib\Sms\Support;
use Aws\Ses\SesClient;
use Aws\Sns\SnsClient;
use Aws\Ses\Exception\SesException;


class Sms extends BaseSms {
    public function send($phone,$code)
    {

//        //todo   send sms
        $snsClient = new SesClient([
            'region'      => 'us-west-2',//这是亚马逊在新加坡的服务器，具体要根据情况决定
//            'credentials' => [
//                'key'         => 'AKIAJE353SOUXYK5P4UA',
//                'secret'      => 'AhTf8eokqpm+buQszf7Fa80/33bJbqLMUWm2NRwKzM3f',
//            ],
            'version'     => '2010-12-01',    //一般在aws的官方api中会有关于这个插件的版本信息
            'debug'       => false,
        ]);
//
//////        $topic = $snsClient->createTopic([
//////            'Name' => 'abc'             //自定义
//////        ]);                             //如果已经存在一个同名的topic，则不会重新创建
////        $args = [
////            'Message' => 'Hello, world!',           // REQUIRED
////            'PhoneNumber' => '+8618656560190',
////        ];
////        $res = $snsClient->Publish($args);
////        $snsClient->Host= "tls://email-smtp.us-east.amazonaws.com"; // Amazon SES
////        $snsClient->Port = 465;  // SMTP Port
//        $result = $snsClient->sendEmail([
//            'Destination' => [
////                'BccAddresses' => [
////                ],
////                'CcAddresses' => [
////                    'recipient3@example.com',
////                ],
//                'ToAddresses' => [
//                    '527837702@qq.com',
//                ],
//            ],
//            'Message' => [
//                'Body' => [
//                    'Html' => [
//                        'Charset' => 'UTF-8',
//                        'Data' => 'This message body contains HTML formatting. It can, for example, contain links like this one: Amazon SES Developer Guide.',
//                    ],
//                    'Text' => [
//                        'Charset' => 'UTF-8',
//                        'Data' => 'This is the message body in text format.',
//                    ],
//                ],
//                'Subject' => [
//                    'Charset' => 'UTF-8',
//                    'Data' => 'Test email',
//                ],
//            ],
//            'ReplyToAddresses' => [
//            ],
//            'ReturnPath' => '',
//            'ReturnPathArn' => '',
//            'Source' => 'sender@example.com',
//            'SourceArn' => '',
//        ]);
////        var_dump(1);
//        var_dump($result);
//        var_dump(2);


        //eg
        // Replace path_to_sdk_inclusion with the path to the SDK as described in
// http://docs.aws.amazon.com/aws-sdk-php/v3/guide/getting-started/basic-usage.html
        define('REQUIRED_FILE','path_to_sdk_inclusion');

// Replace sender@example.com with your "From" address.
// This address must be verified with Amazon SES.
        define('SENDER', 'sender@example.com');

// Replace recipient@example.com with a "To" address. If your account
// is still in the sandbox, this address must be verified.
//        define('RECIPIENT', 'recipient@example.com');

// Specify a configuration set. If you do not want to use a configuration
// set, comment the following variable, and the
// 'ConfigurationSetName' => CONFIGSET argument below.
        define('CONFIGSET','ConfigSet');

// Replace us-west-2 with the AWS Region you're using for Amazon SES.
//        define('REGION','us-west-2');

//        define('SUBJECT','Amazon SES test (AWS SDK for PHP)');

//        define('HTMLBODY','<h1>AWS Amazon Simple Email Service Test Email</h1>'.
//            '<p>This email was sent with <a href="https://aws.amazon.com/ses/">'.
//            'Amazon SES</a> using the <a href="https://aws.amazon.com/sdk-for-php/">'.
//            'AWS SDK for PHP</a>.</p>');
        define('TEXTBODY','This email was send with Amazon SES using the AWS SDK for PHP.');

//        define('CHARSET','UTF-8');


//        $client = SesClient::factory(array(
//            'version'=> 'latest',
//            'region' => 'us-west-2',
//            'credentials' => [
//                'key'         => 'AKIAJE353SOUXYK5P4UA',
//                'secret'      => 'AhTf8eokqpm+buQszf7Fa80/33bJbqLMUWm2NRwKzM3f',
//            ],
//
//        ));

        try {
            $result = $snsClient->sendEmail([
                'Destination' => [
                    'ToAddresses' => [
                        'funy_suny@163.com',
                    ],
                ],
                'Message' => [
                    'Body' => [
                        'Html' => [
                            'Charset' => 'UTF-8',
                            'Data' => '<h1>AWS Amazon Simple Email Service Test Email</h1>'.
                                '<p>This email was sent with <a href="https://aws.amazon.com/ses/">'.
                                'Amazon SES</a> using the <a href="https://aws.amazon.com/sdk-for-php/">'.
                                'AWS SDK for PHP</a>.</p>',
                        ],
                        'Text' => [
                            'Charset' => 'UTF-8',
                            'Data' => '<h1>AWS Amazon Simple Email Service Test Email</h1>'.
                                '<p>This email was sent with <a href="https://aws.amazon.com/ses/">'.
                                'Amazon SES</a> using the <a href="https://aws.amazon.com/sdk-for-php/">'.
                                'AWS SDK for PHP</a>.</p>',
                        ],
                    ],
                    'Subject' => [
                        'Charset' => 'UTF-8',
                        'Data' => 'Amazon SES test (AWS SDK for PHP)',
                    ],
                ],
                'Source' => 'noreply@service.bitboole.com',
                // If you are not using a configuration set, comment or delete the
                // following line
//                'ConfigurationSetName' => 'ConfigSet',
            ]);
            $messageId = $result->get('MessageId');
            echo("Email sent! Message ID: $messageId"."\n");

        } catch (SesException $error) {
            echo("The email was not sent. Error message: ".$error->getAwsErrorMessage()."\n");
        }
        return ['phone'=>$phone,'code'=>$code,'provider'=>'aws','result'=>'ok'];
    }
}