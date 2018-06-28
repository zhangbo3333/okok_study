<?php


namespace App\WorkTemplet;
use App\HttpController\Lib\Email\ManagerEmail;
use EasySwoole\Core\Swoole\Task\AbstractAsyncTask;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Event\TimesLimit;

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
        $data =  ManagerEmail::getInstance()->send($taskData['email'],$taskData['content'],$taskData['name'],$taskData['subject']);
        return ['id'=>$id,'data'=>$data];
    }


    public function finish($result, $task_id)
    {
            $arr = [
                'service_provider'=>$result['data']['server_provider'],
                'result'=>$result['data']['result'],
                'updated_at'=>date('Y-m-d H:i:s')
            ];
        if($result['data']['result'] == 'ok'){
            $arr['receive_time'] = $result['data']['receive_time'];
        }else{
            $arr['remark'] = $result['data']['remark'];
        }
        $res = Capsule::table('email')->where('id',$result['id'])->update($arr);
        if($res){
            //todo
            $obj = TimesLimit::getInstance($result['data']['email'],1);
            $obj->incr();
        }else{
            //todo
        }
    }
}