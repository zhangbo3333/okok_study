<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/3/3
 * Time: 下午6:14
 */

namespace App\HttpController;


use EasySwoole\Core\Component\Pool\PoolManager;
use EasySwoole\Core\Http\AbstractInterface\Controller;
use EasySwoole\Core\Http\Message\Status;
use EasySwoole\Core\Swoole\ServerManager;
use Illuminate\Database\Capsule\Manager as Capsule;

class Index extends Controller
{

    //测试路径 /index.html
    function index()
    {
//        // TODO: Implement index() method.
//        $this->response()->write('hello world');
//        $pool = PoolManager::getInstance()->getPool(RedisPool::class);
//        $redis = $pool->getObj();
//        var_dump($redis->exec('set','name',123456));
//        $pool->freeObj($redis);
//        $this->response()->write('上帝保佑你');
//            $redis = new \Swoole\Coroutine\Redis();
//            $redis->connect('127.0.0.1',6379);
//            $redis->set('name','ok  u win ');
//            $res = $redis->get('name');
//            $redis->set('age',20);
//            $this->response()->write($res);
//        $this->response()->write('111');
//        $version = Capsule::select('select version();');
//        $this->response()->write($version);
//        $data = Capsule::table('t_log_sms')->where('id',467)->get();
//        $pool = PoolManager::getInstance()->getPool('App\Utility\RedisPool');
//        $redis = $pool->getObj();
//        $redis->exec('set','age','hahah');
//        $res = $redis->exec('get','age');
//        var_dump($res);
//        $pool->freeObj($redis);
//        $pool = PoolManager::getInstance()->getPool('App\Utility\MysqlPool2'); // 获取连接池对象
//        var_dump($pool);
//        $db = $pool->getObj();
//        var_dump($db);

    }
    //测试路径 /test/index.html
    function test()
    {
        $ip = ServerManager::getInstance()->getServer()->connection_info($this->request()->getSwooleRequest()->fd);
        var_dump($ip);
        $ip2 = $this->request()->getHeaders();
        var_dump($ip2);
        $this->response()->write('index controller test');
    }

    /*
     * protected 方法对外不可见
     *  测试路径 /hide/index.html
     */
    protected function hide()
    {
        var_dump('this is hide method');
    }

    protected function actionNotFound($action): void
    {
        $this->response()->withStatus(Status::CODE_NOT_FOUND);
        $this->response()->write("{$action} is not exist");
    }

    function a()
    {
        $this->response()->write('index controller router');
    }

    function a2()
    {
        $this->response()->write('index controller router2');
    }

    function test2(){
        $this->response()->write('this is controller test2 and your id is '.$this->request()->getRequestParam('id'));
    }
}