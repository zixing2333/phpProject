<?php

namespace app\admin\controller;


class Comment extends Base
{
    //评论列表
    public function list() {
        $comment = \app\common\model\Comment::with('article,member')->order('create_time', 'desc')->paginate(10);
        $this->assign('comment', $comment);

        return $this->fetch('list');
    }

    //删除评论
    public function del() {
        $id = $this->request->post('id');
        $comment = \app\common\model\Comment::get($id);
        $result = $comment->delete();
        if ($result) {
            $this->success('删除评论成功~', 'admin/comment/list');
        }else {
            $this->error('删除评论失败！');
        }
    }
}
