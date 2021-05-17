<?php


namespace app\common\validate;


use think\Validate;

class Article extends Validate
{
    //验证规则
    protected $rule = [
        'title|文章标题'     =>  'require|unique:article',
        'author|作者'       =>  'require',
        'tags|文章标签'      =>  'require',
        'cate_id|所属栏目'   =>  'require',
        'desc|文章描述'      =>  'require',
        'content|文章内容'   =>  'require'
    ];

    //文章添加场景验证
    public function sceneAdd() {
        return $this->only(['title', 'author', 'desc','tags','content','cate_id']);
    }
    //文章编辑场景验证
    public function sceneEdit() {
        return $this->only(['title','desc','tags','content','cate_id']);
    }

    //文章添加场景验证
    public function sceneContriadd() {
        return $this->only(['title', 'desc','tags','content','cate_id']);
    }
}