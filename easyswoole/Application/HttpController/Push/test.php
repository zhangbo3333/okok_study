<?php
namespace  App\HttpController\Push;
use EasySwoole\Core\Http\AbstractInterface\Controller;
class test extends Controller{
    public function index()
    {
        $this->response()->write('1234566');
    }
}