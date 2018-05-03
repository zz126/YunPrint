<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/27
 * Time: 9:32
 */
namespace app\user\controller;
header("Access-Control-Allow-Origin:http://localhost:8000");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Credentials: true");
use think\Controller;
use think\Db;
use think\exception\ErrorException;
use think\exception\PDOException;
use think\Request;
use think\Session;

class Login extends Base
{
    public function index()
    {
        return $this->fetch();
    }

    public function login()
    {
        return $this->fetch();
    }

    /**
     * 注册函数
     * @param Request $request
     */
    public function register(Request $request)
    {
        $username = $request->post('username');
        $password = $request->post('password');
        $realname = $request->post('realname');
        $tel = $request->post('tel');
        $time = date("Y-m-d H:i:s", time());
        try {
            $rel = Db::name('user')
                ->strict(false)
                ->insert([
                    'username' => $username,
                    'password' => $password,
                    'realname' => $realname,
                    'tel' => $tel,
                    'time' => $time]);
            return $this->apireturn('0', '注册成功', $rel);
        } catch (PDOException $e) {
            return $this->apireturn('-1', '注册失败', '');
        }
    }

    /**
     * 登录判断函数
     * @param Request $request
     */
    public function oklogin(Request $request)
    {
        $username = $request->post('username');
        $password = $request->post('password');
        $rel = Db::name('user')
            ->field(['id', 'username', 'realname', 'tel', 'time'])
            ->where(['username' => $username, 'password' => $password])
            ->find();
        if (empty($rel)) {
            return $this->apireturn('-1', '用户名或密码错误', $rel);
        } else {
            Session::set('user', $rel);
            return $this->apireturn('0', '登录成功', $rel);
        }
    }

    /**
     * 判断是否登录
     * @return \think\response\Json
     */
    public function islogin()
    {
        if (Session::has('user')) {
            return $this->apireturn('0', 'Success', Session::get('user'));
        } else {
            return $this->apireturn('-1', 'No login.', empty(Session::has('user')));
        }
    }

    /**
     * 注销登录
     */
    public function dellogin()
    {
        Session::delete('user');
    }

}