<?php


namespace  App\HttpController\Push;

use EasySwoole\Core\Http\AbstractInterface\Controller;
use App\WorkTemplet\Sms as  sendSms;
use EasySwoole\Core\Swoole\Task\TaskManager;
use App\Event\TimesLimit;
use Illuminate\Database\Capsule\Manager as Capsule;


class Sms extends Controller {


    public function index(){
        $this->response()->write('1231234561');
        var_dump('123');
        var_dump(Capsule::table('test')->insertGetId(['name'=>'张三','age'=>12]));
        var_dump('456');
    }

    public function sendSms()
    {
        $request = $this->request();
        $data= $request->getParsedBody();
        //次数检查
        $timesLimit = new TimesLimit();
        if($timesLimit->number($data['phone'],2)){
//            //投递任务
        $obj = new sendSms(['phone'=>$data['phone'],'content'=>$data['content']]);
        TaskManager::async($obj);
        $this->writeJson(200,['msg'=>'ok'],'ok');
        }else{
            $this->writeJson(403,[],'too much send,waiting a moment');
        }

    }
}