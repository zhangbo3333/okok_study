<?php


namespace  App\HttpController\Push;

use EasySwoole\Core\Http\AbstractInterface\Controller;
use App\WorkTemplet\Email as  sendEmail;
use EasySwoole\Core\Swoole\Task\TaskManager;
use App\Event\TimesLimit;

class Email extends Controller {


    public function index(){
        $this->response()->write('123');
    }

    public function sendEmail()
    {
        $request = $this->request();
        $data= $request->getParsedBody();
        //次数检查
        $number = TimesLimit::getInstance($data['email'],1);
        if($number->number()){
            //投递任务
            $obj = new sendEmail(['email'=>$data['email'],'content'=>$data['content'],'name'=>$data['name'],'subject'=>$data['subject']]);
            TaskManager::async($obj);
            $this->writeJson(200,['msg'=>'ok'],'ok');
        }else{
            $this->writeJson(403,[],'too much send,waiting a moment ');
        }

    }
}