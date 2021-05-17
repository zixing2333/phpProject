<?php


namespace app\common\validate;


use think\Validate;

class Cate extends Validate
{
    //验证规则
    protected $rule = [
        'catename'      =>  'require|unique:cate',
        'sort'          =>  'require'
    ];

    //验证添加场景
    public function sceneAdd() {
        return $this->only(['catename', 'sort']);
    }
    //验证排序场景
    public function sceneSort() {
        return $this->only(['sort']);
    }
    //验证栏目编辑场景
    public function sceneEdit() {
        return $this->only(['catename']);
    }
}