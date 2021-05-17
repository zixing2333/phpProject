<?php


namespace app\common\validate;


use think\Validate;

class Member extends Validate
{
    //验证规则
    protected $rule = [
        'username|用户名称'      =>  'require|unique:member',
        'password|用户密码'      =>  'require',
        'conpass|确认密码'       =>  'require|confirm:password',
        'nickname|用户昵称'      =>  'require',
        'email|邮箱'            =>  'require|email|unique:member',
        'verify|验证码'         =>  'require|captcha'
    ];

    //错误信息
    protected $message = [
        'conpass.confirm'      =>  '确认密码和密码不一致'
    ];

    //添加验证场景
    public function sceneAdd() {
        return $this->only(['username', 'password', 'nickname', 'email']);
    }
    //编辑验证场景
    public function sceneEdit() {
        return $this->only(['nickname']);
    }
    //注册验证场景
    public function sceneRegister() {
        return $this->only(['username', 'password', 'conpass','nickname', 'email', 'verify']);
    }
    //登录验证场景
    public function sceneLogin() {
        return $this->only(['username', 'password', 'verify'])
            ->remove('username', 'unique');
    }
}