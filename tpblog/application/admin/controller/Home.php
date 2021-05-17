<?php


namespace app\admin\controller;


use think\Controller;
use think\facade\Session;

class Home extends Base
{
    //后台首页
    public function index() {
        return $this->fetch('index');
    }
    //退出登录
    public function loginout() {
        //清空session
        Session::clear();
        if (Session::has('admin.id')) {
            $this->error('退出失败！');
        }else {
            $this->success('退出成功~', 'admin/index/login');
        }
    }

}