<?php


namespace App\WorkTemplet;
use App\HttpController\Lib\Email\ManagerEmail;
use EasySwoole\Core\Swoole\Task\AbstractAsyncTask;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Event\SmsNumber;

class Email  extends AbstractAsyncTask
{
    public function run($taskData, $taskId, $fromWorkerId)
    {
        $data = [
            'email'=>$taskData['email'],
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
        $id = Capsule::table('email')->insertGetId($data);

        //todo
        try{
            $data =  ManagerEmail::getInstance()->send($taskData['email'],$taskData['content']);
            return ['id'=>$id,'data'=>$data];
        }catch (\ErrorException $e){
            //todo
        }

    }


    public function finish($result, $task_id)
    {


        $arr = [

            'service_provider'=>$result['data']['server_provider'],
            'result'=>$result['data']['result'],
            'receive_time'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        $res = Capsule::table('email')->where('id',$result['id'])->update($arr);
        if($res){
            //todo
//            $obj = new SmsNumber($result['data']['phone']);
//            $obj->incr();
            echo '调试结束';
        }else{
            //todo
        }
    }
}