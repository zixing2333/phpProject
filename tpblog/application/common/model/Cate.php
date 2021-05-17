<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Cate extends Model
{
    //软删除
    use SoftDelete;
    //关联文章
    public function article() {
        return $this->hasMany('Article', 'cate_id', 'id');
    }
    //栏目添加验证
    public function add($data) {
        //验证数据
        $validate = new \app\common\validate\Cate();
        if (!$validate->scene('add')->check($data)) {
            return $validate->getError();
        }

        //添加数据
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        }else {
            return '栏目添加失败！';
        }
    }

    //排序验证
    public function sort($data) {
        $validate = new \app\common\validate\Cate();
        if (!$validate->scene('sort')->check($data)) {
            return $validate->getError();
        }
        //更新排序
        $cate = $this->where('id', $data['id'])->find();
        $cate->sort = $data['sort'];
        $result = $cate->save();
        if ($result) {
            return 1;
        }else {
            return '排序更新失败！';
        }
    }

    //栏目编辑验证
    public function edit($data) {
        $validate = new \app\common\validate\Cate();
        if (!$validate->scene('edit')->check($data)) {
            return $validate->getError();
        }
        //更新
        $cateInfo = $this->where('id', $data['id'])->find();
        $cateInfo->catename = $data['catename'];
        $result = $cateInfo->save();
        if ($result) {
            return 1;
        }else {
            return '栏目编辑失败！';
        }
    }
}
