<?php

namespace app\index\controller;


use app\common\validate\Comment;

class Article extends Base
{
    //文章详情
    public function info() {
        $id = $this->request->param('id');
        $articleInfo = \app\common\model\Article::with('comments,comments.member')->where('id', $id)->find();
        //点击量自增1
        $articleInfo->setInc('click');
        //统计评论量
//        $commentNum = \app\common\model\Article::removeOption('where')->with('comments')->where('id', $id)->count('article_id');
        $viewData = [
            'articleInfo'       =>  $articleInfo,
        ];
        $this->assign($viewData);

        return $this->fetch('info');
    }

    //评论添加
    public function comm()
    {
        if ($this->request->isAjax()) {
            $data = [
                'content'       =>  $this->request->post('content'),
                'article_id'    =>  $this->request->post('article_id'),
                'member_id'     =>  $this->request->post('member_id')
            ];
            $comment = new \app\common\model\Comment();
            $result = $comment->comm($data);
            if ($result == 1) {
                $this->success('评论成功');
            }else {
                $this->error($result);
            }
        }
    }
}
