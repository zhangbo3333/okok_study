<?php
namespace App\HttpController\Lib\Sms\Support;
use Aws\Sns\SnsClient;
use EasySwoole\Config;


class Aws extends BaseSms {

    private $provider = 'aws';
    private $snsClient;

    public function __construct()
    {
        $this->getSNSClient();
    }

    public function send($phone,$content)
    {
        $args = [
            'Message' => $content,
            'PhoneNumber' => $phone,
        ];
        $result = $this->snsClient->Publish($args);
        if($result->data['@metadata']['statusCode'] == 200){
            var_dump(200);
        }
//        ['server_provider'=>$this->provider,'result'=>'ok','receive_time'=>date('Y-m-d H:i:s')];
    }

    public function getSNSClient()
    {
        $conf = Config::getInstance()->getConf('AWS_SMS');
        $snsClient = new SnsClient([
            'region'      => $conf['HOST'],
            'credentials' => [
                'key'         => $conf['KEY'],
                'secret'      => $conf['SECRET'],
            ],
            'version'     => $conf['VERSION'],
            'debug'       => false,
        ]);
        $this->snsClient  = $snsClient;
    }

}