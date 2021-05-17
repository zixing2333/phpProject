<?php
namespace app\index\controller;


use app\common\model\Article;
use app\common\model\Cate;
use app\common\model\Member;
use think\facade\Session;

class Index extends Base
{
    //前台首页
    public function index() {
        $where = [];
        $catename = null;
        if ($this->request->has('id')) {
            $where = [
                'cate_id'   =>  $this->request->param('id')
            ];
            $catename = Cate::where('id', $this->request->param('id'))->value('catename');
        }

        $articles = Article::where($where)->order('create_time', 'desc')->paginate(5);

        $viewData = [
            'articles'       =>  $articles,
            'catename'       =>  $catename
        ];
        $this->assign($viewData);

        return $this->fetch('index');
    }

    //用户注册
    public function register() {
        if ($this->request->isAjax()) {
            $data = [
                'username'      =>  $this->request->post('username'),
                'password'      =>  $this->request->post('password'),
                'conpass'       =>  $this->request->post('conpass'),
                'nickname'      =>  $this->request->post('nickname'),
                'email'         =>  $this->request->post('email'),
                'verify'        =>  $this->request->post('verify'),
            ];
            $member = new Member();
            $result = $member->register($data);
            if ($result == 1) {
                $this->success('注册成功~', 'index/index/login');
            }else {
                $this->error($result);
            }
        }

        return $this->fetch('register');
    }

    //用户登录
    public function login() {
        if ($this->request->isAjax()) {
            $data = [
                'username'      =>  $this->request->post('username'),
                'password'      =>  $this->request->post('password'),
                'verify'        =>  $this->request->post('verify'),
            ];
            $member = new Member();
            $result = $member->login($data);
            if ($result == 1) {
                $this->success('登录成功！', 'index/index/index');
            }else {
                $this->error($result);
            }
        }

        return $this->fetch('login');
    }

    //退出
    public function loginout()
    {
        Session::clear();
        $this->success('退出成功~', 'index/index/index');
    }

    //搜索
    public function search() {
        $keyword = $this->request->get('keyword');
        $where = '%'.$keyword.'%';
        $articles = Article::where('title', 'like', $where)->order('create_time', 'desc')->paginate(5);

        //参数名跟index中的一样
        $viewData = [
            'articles'      =>  $articles,
            'catename'      =>  $keyword
        ];
        $this->assign($viewData);

        return $this->fetch('index');

    }
}
