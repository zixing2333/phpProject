<?php

namespace app\index\controller;

use app\common\model\Article;
use app\common\model\Cate;
use app\common\model\System;
use think\Controller;
use think\facade\View;

class Base extends Controller
{
    //使用共享视图
    protected function initialize()
    {
        $cates = Cate::order('sort', 'asc')->all();
        $webInfo = System::find();
        $isTop = Article::where('is_top', 1)->order('create_time', 'desc')->limit(10)->select();
        $viewData = [
            'cates'     =>  $cates,
            'webInfo'   =>  $webInfo,
            'isTop'     =>  $isTop
        ];
        View::share($viewData);
    }
    //用户注册
}
