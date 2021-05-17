<?php

namespace app\admin\controller;

use app\common\model\Admin;
use think\Controller;
use think\facade\Session;

class Index extends Controller
{
    //后台登录
    public function login() {
        if ($this->request->isAjax()) {
            $data = [
                'username'      =>  $this->request->post('username'),
                'password'      =>  $this->request->post('password')
            ];

            //验证
            $admin = new Admin();
            $result = $admin->login($data);
            if ($result == 1) {
                //登录成功
                $this->success('登录成功！', 'admin/home/index');
            }else {
                //登录失败
                $this->error($result);
            }
        }

        return $this->fetch('login');
    }
    //注册
    public function register() {
        if ($this->request->isAjax()) {
            $data = [
                'username'      =>  $this->request->post('username'),
                'password'      =>  $this->request->post('password'),
                'conPass'       =>  $this->request->post('conPass'),
                'nickname'      =>  $this->request->post('nickname'),
                'email'         =>  $this->request->post('email'),
            ];
            //实例化模型对象
            $admin = new Admin();
            $result = $admin->register($data);

            if ($result == 1) {
                $this->success('注册成功~', 'admin/index/login');
            }else {
                $this->error($result);
            }
        }
        return $this->fetch('register');
    }

    //忘记密码，发送验证码
    public function forget() {
        if ($this->request->isAjax()) {
            //生成随机数
            $code = mt_rand(1000, 9999);
            Session::set('code',$code);

            //是否是以注册邮箱
            $email = $this->request->post('email');
            $admin = new Admin();
            $res = $admin->where('email')->find();
            if ($res) {

                $result = mailto($email, '验证码', '随机验证码为：'.$code);

                if ($result) {
                    $this->success('验证码发送成功！');
                }else {
                    $this->error('验证码发送失败~');
                }
            }else {
                $this->error('邮箱错误或未注册~');
            }
        }
        return $this->fetch('forget');
    }

    //忘记密码，填写验证码，重置密码
    public function reset() {
        if ($this->request->isAjax()) {
            $data = [
                'code'      =>  $this->request->post('code'),
                'email'     =>  $this->request->post('email')
            ];

            $admin = new Admin();
            $result = $admin->reset($data);
            if ($result == 1) {
                $this->success('密码重置成功！请去邮箱查看新密码~', 'admin/index/login');
            }else {
                $this->error($result);
            }
        }
    }

//    public function login() {
//        if ($this->request->isAjax()) {
//            $data = [
//                'username'      =>  $this->request->post('username'),
//                'password'      =>  $this->request->post('password')
//            ];
//
//            $admin = new Admin();
//            $result = $admin->login($data);
//
//            if ($result == 1) {
//                $this->success('登录成功！', 'admin/home/index');
//            }else {
//                $this->error($result);
//            }
//        }
//
//        return $this->fetch('login');
//    }
}
