<?php


namespace app\admin\controller;


use think\Controller;
use think\facade\Session;

class Base extends Controller
{
    public function initialize()
    {
       if (!Session::has('admin')) {
           $this->redirect('admin/index/login');
       }
    }
}