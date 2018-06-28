<?php


namespace App\WorkTemplet;
use App\HttpController\Lib\Sms\ManagerSms;
use EasySwoole\Core\Swoole\Task\AbstractAsyncTask;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Event\TimesLimit;

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

        $data =  ManagerSms::getInstance()->send($taskData['phone'],$taskData['content']);
        return ['id'=>$id,'data'=>$data,'phone'=>$taskData['phone']];


    }

    public function finish($result, $task_id)
    {
        $arr = [
            'service_provider'=>$result['data']['provider'],
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        if($result['data']['result'] == 'ok'){
            $arr['result'] = 'ok';
            $arr['receive_time']= date('Y-m-d H:i:s');
        }
        $res = Capsule::table('sms')->where('id',$result['id'])->update($arr);
        if($res){
            //todo
            $obj = new TimesLimit();
            $obj->incr($result['phone'],2);
        }else{
            //todo
            
        }

    }
}