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
    }
}