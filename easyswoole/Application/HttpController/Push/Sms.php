<?php


namespace  App\HttpController\Push;

use EasySwoole\Core\Http\AbstractInterface\Controller;
use App\WorkTemplet\Sms as  sendSms;
use EasySwoole\Core\Swoole\Task\TaskManager;
use App\Event\SmsNumber;


class Sms extends Controller {


    public function index(){
        $this->response()->write('123');
    }

    public function sendSms()
    {
        $request = $this->request();
        $data= $request->getParsedBody();
        //次数检查
        $number = new SmsNumber($data['phone']);
        if($number->check()){
            //投递任务
        $obj = new sendSms(['phone'=>$data['phone'],'code'=>$data['code']]);
        TaskManager::async($obj);
        $this->writeJson(200,['msg'=>'ok'],'ok');
        }else{
            $this->writeJson(403,[],'too much send,you can not send any sms today ');
        }

    }
}