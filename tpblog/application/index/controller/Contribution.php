<?php

namespace app\index\controller;


use app\common\model\Cate;
use think\facade\Session;

class Contribution extends Base
{
    //用户投稿
    public function contriAdd() {
        if ($this->request->isAjax()) {
            $data = [
                'title'     =>  $this->request->post('title'),
                'author'    =>  Session::get('userInfo.nickname'),
                'cate_id'   =>  $this->request->post('cate_id'),
                'desc'      =>  $this->request->post('desc'),
                'tags'      =>  $this->request->post('tags'),
                'content'   =>  $this->request->post('content'),
            ];
            $article = new \app\common\model\Article();
            $result = $article->contriadd($data);
            if ($result == 1) {
                $this->success('投稿成功~','index/index/index');
            }else {
                $this->error($result);
            }
        }

        $cates = Cate::all();
        $this->assign('cates', $cates);

        return $this->fetch('contriAdd');
    }
}
