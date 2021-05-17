<?php
namespace app\common\validate;


use think\Validate;

class Admin extends Validate
{
    //规则
    protected $rule = [
        'username|管理员账号'      =>  'require',
        'password|密码'           =>  'require',
        'conPass|确认密码'         =>  'require|confirm:password',
        'nickname|昵称'           =>  'require',
        'email|邮箱'              =>  'require|email|unique:admin',
        'code|验证码'              =>  'require'
    ];
    //规则错误信息
    protected $message = [
        'conPass.confirm'       =>  '确认密码和密码不一致',
        'username.unique'       =>  '管理员账号已存在'
    ];

    //登录场景验证
    public function sceneLogin() {

        return $this->only(['username','password']);
    }
    //注册场景验证
    public function sceneRegister() {

        return $this->only(['username','password','conPass','nickname','email'])
                    ->append('username', 'unique:admin');
    }
    //重置密码场景验证
    public function sceneReset() {
        return $this->only(['code']);
    }
    //管理员添加场景验证
    public function sceneAdd() {
        return $this->only(['username','password','conPass','nickname','email'])
                    ->append('username', 'unique:admin');
    }
    //管理员编辑场景验证
    public function sceneEdit() {
        return $this->only(['nickname']);
    }

}