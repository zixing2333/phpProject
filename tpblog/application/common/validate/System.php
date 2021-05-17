<?php


namespace app\common\validate;


use think\Validate;

class System extends Validate
{
    //验证规则
    protected $rule = [
        'webname|系统标题'      =>  'require',
        'copyright|版权信息'    =>  'require'
    ];
}