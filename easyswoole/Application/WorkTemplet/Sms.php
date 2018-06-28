<?php


namespace App\WorkTemplet;
use App\HttpController\Lib\Sms\ManagerSms;
use EasySwoole\Core\Swoole\Task\AbstractAsyncTask;
use Illuminate\Database\Capsule\Manager as Capsule;

class Sms  extends AbstractAsyncTask
{
    public function run($taskData, $taskId, $fromWorkerId)
    {
        $data  = [
            'phone'=>$taskData['phone'],
            'content'=>$taskData['content'],
            'service_provider'=>'',
            'result'=>'',
            'send_time'=>date('Y-m-d H:i:s'),
            'year'=>(int)date('Y'),
            'month'=>(int)date('m'),
            'day'=>(int)date('d'),
            'week'=>(int)date('w'),
            'remark'=>''
        ];
        $id = Capsule::table('sms')->insertGetId($data);
        //todo
        try{
            $data =  ManagerSms::getInstance()->send($taskData['phone'],$taskData['content']);
            return ['id'=>$id,'data'=>$data];
        }catch (\ErrorException $e){
            //todo
        }

    }


    public function finish($result, $task_id)
    {
//        $arr = [
//            'service_provider'=>$result['data']['provider'],
//            'result'=>$result['data']['result'],
//            'receive_time'=>date('Y-m-d H:i:s'),
//            'updated_at'=>date('Y-m-d H:i:s')
//        ];
//        $res = Capsule::table('sms')->where('id',$result['id'])->update($arr);
//        if($res){
//            //todo
////            $obj = new SmsNumber($result['data']['phone']);
////            $obj->incr();
//        }else{
//            //todo
//        }

    }
}