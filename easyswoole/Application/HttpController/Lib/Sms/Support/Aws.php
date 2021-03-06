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
        try{
            $this->snsClient->Publish($args);
            return   ['server_provider'=>$this->provider,'result'=>'ok','receive_time'=>date('Y-m-d H:i:s')];
        }
        catch(\Exception $e){
            return ['server_provider'=>$this->provider,'result'=>'','remark'=>$e->getMessage()];
        }
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