<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Article extends Model
{
    //软删除
    use SoftDelete;

    //关联栏目表
    public function cate() {
        return $this->belongsTo('Cate', 'cate_id', 'id');
    }

    //关联评论
    public function comments() {
        return $this->hasMany('Comment', 'article_id', 'id');
    }

    //文章添加验证
    public function add($data) {
        $validate = new \app\common\validate\Article();
        if (!$validate->scene('add')->check($data)) {
            return $validate->getError();
        }

        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        }else {
            return '文章添加失败！';
        }
    }
    //文章编辑验证
    public function edit($data) {
        $validate = new \app\common\validate\Article();
        if (!$validate->scene('edit')->check($data)) {
            return $validate->getError();
        }
        $article = $this->where('id', $data['id'])->find();
        $article->title     =   $data['title'];
        $article->tags      =   $data['tags'];
        $article->cate_id   =   $data['cate_id'];
        $article->is_top    =   $data['is_top'];
        $article->desc      =   $data['desc'];
        $article->content   =   $data['content'];
        $result = $article->save();
        if ($result) {
            return 1;
        }else {
            return '文章编辑失败！';
        }
    }

    //用户投稿验证
    public function contriadd($data) {
        $validate = new \app\common\validate\Article();
        if (!$validate->scene('contriadd')->check($data)) {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        }else {
            return '投稿失败！';
        }
    }
}
