<?php
/**
 * Created by PhpStorm.
 * User: XZFFF
 * Date: 2017/4/11
 * Time: 20:43
 */

namespace app\user\controller;
header("Access-Control-Allow-Origin:http://localhost:8000");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Credentials: true");
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Base extends Controller
{

    function __construct()
    {
        ob_clean();
        parent::__construct();
        if(empty(Session::has('user'))) {
            redirect('index/login');
        }
    }

    /**
     * 接口返回格式
     * @param $errcode
     * @param $errmsg
     * @param $data
     * @param $status
     * @return \think\response\Json
     */
    protected function apireturn($errcode, $errmsg, $data)
    {
        return json([
            'errcode' => $errcode,
            'errmsg' => $errmsg,
            'data' => $data
        ]);
    }

}