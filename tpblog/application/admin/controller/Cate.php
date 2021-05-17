<?php

namespace app\admin\controller;


class Cate extends Base
{
    //栏目列表
    public function list() {
        //查询数据
        $cate = new \app\common\model\Cate();
        $cates = $cate->order('sort', 'asc')->paginate(2);
        $cateData = [
            'cates'     =>  $cates
        ];
        $this->assign('cateData', $cateData);

        return $this->fetch('list');
    }

    //栏目添加
    public function add() {
        if ($this->request->isAjax()) {
            $data = [
                'catename'      =>  $this->request->post('catename'),
                'sort'          =>  $this->request->post('sort')
            ];
            $cate = new \app\common\model\Cate();
            $result = $cate->add($data);
            if ($result ==1) {
                $this->success('栏目添加成功~', 'admin/cate/list');
            }else {
                $this->error($result);
            }
        }
        return $this->fetch('add');
    }

    //排序
    public function sort() {
        $data = [
            'id'        =>  $this->request->post('id'),
            'sort'      =>  $this->request->post('sort')
        ];
        $cate = new \app\common\model\Cate();
        $result = $cate->sort($data);
        if ($result == 1) {
            $this->success('排序更新成功', 'admin/cate/list');
        }else {
            $this->error($result);
        }
    }

    //栏目编辑
    public function edit() {
        if ($this->request->isAjax()) {
            $data = [
                'id'        =>  $this->request->post('id'),
                'catename'  =>  $this->request->post('catename')
            ];
            $cate = new \app\common\model\Cate();
            $result = $cate->edit($data);
            if ($result == 1) {
                $this->success('栏目编辑成功~', 'admin/cate/list');
            }else {
                $this->error($result);
            }
        }

        //根据id查询数据
        $cate = new \app\common\model\Cate();
        $cateInfo = $cate->where('id', $this->request->param('id'))->find();
        $this->assign('cateInfo', $cateInfo);

        return $this->fetch('edit');
    }

    //栏目删除
    public function del() {
        $id = $this->request->post('id');
        $cateInfo = \app\common\model\Cate::with('article,article.comments')->get($id);
        foreach ($cateInfo['article'] as $k => $v) {
            $v->together('comments')->delete();
        }
        $result = $cateInfo->together('article')->delete();
        if ($result) {
            $this->success('删除成功~', 'admin/cate/list');
        }else {
            $this->error('删除失败！');
        }
    }
}
