<?php
namespace App\HttpController\user2;
use EasySwoole\Core\Http\AbstractInterface\Controller;
class test extends Controller
{
    public function index()
    {
        $this->response()->write('a test');
    }
}