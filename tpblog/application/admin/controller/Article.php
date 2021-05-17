<?php

namespace app\admin\controller;


class Article extends Base
{
    //文章列表
    public function list() {
        $article = new \app\common\model\Article();
        $articleInfo = $article->with('cate')->order(['is_top'=>'desc', 'create_time'=>'desc'])->paginate(10);
        $this->assign('articleInfo', $articleInfo);

        return $this->fetch('list');
    }

    //文章添加
    public function add() {
        if ($this->request->isAjax()) {
            $data = [
                'title'     =>  $this->request->post('title'),
                'author'    =>  $this->request->post('author'),
                'desc'      =>  $this->request->post('desc'),
                'tags'      =>  $this->request->post('tags'),
                'content'   =>  $this->request->post('content'),
                'is_top'    =>  $this->request->post('is_top', 0),
                'cate_id'   =>  $this->request->post('cateid')
            ];
            $article = new \app\common\model\Article();
            $result = $article->add($data);
            if ($result == 1) {
                $this->success('添加成功~', 'admin/article/list');
            }else {
                $this->error($result);
            }
        }
        //查询栏目名称
        $cate = \app\common\model\Cate::all();
        $this->assign('cate', $cate);

        return $this->fetch('add');
    }

    //改变推荐
    public function top() {
        $data = [
            'id'        =>  $this->request->post('id'),
            'is_top'    =>  $this->request->post('isTop') ? 0 : 1
        ];
        $article = \app\common\model\Article::get($data['id']);
        $article->is_top = $data['is_top'];
        $result = $article->save();
        if ($result) {
            $this->success('设置成功~', 'admin/article/list');
        }else {
            $this->error('设置失败！');
        }
    }

    //文章编辑
    public function edit() {
        if ($this->request->isAjax()) {
            $data = [
                'id'        =>  $this->request->post('id'),
                'title'     =>  $this->request->post('title'),
                'author'    =>  $this->request->post('author'),
                'desc'      =>  $this->request->post('desc'),
                'tags'      =>  $this->request->post('tags'),
                'content'   =>  $this->request->post('content'),
                'is_top'    =>  $this->request->post('is_top', 0),
                'cate_id'   =>  $this->request->post('cateid')
            ];
            $article = new \app\common\model\Article();
            $result = $article->edit($data);
            if ($result == 1) {
                $this->success('文章编辑成功~', 'admin/article/list');
            }else {
                $this->error($result);
            }
        }

        //查询数据并传给模板
        $articleInfo = \app\common\model\Article::get($this->request->param('id'));
        $cates = \app\common\model\Cate::all();
        $this->assign('articleInfo', $articleInfo);
        $this->assign('cates', $cates);

        return $this->fetch('edit');
    }

    //文章删除
    public function del() {
        $id = $this->request->post('id');
        $articleInfo = \app\common\model\Article::with('comments')->get($id);
        $result = $articleInfo->together('comments')->delete();
        if ($result) {
            $this->success('文章删除成功~', 'admin/article/list');
        }else {
            $this->error('文章删除失败！');
        }
    }
}
