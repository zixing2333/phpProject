<?php

namespace app\common\model;

use think\facade\Session;
use think\Model;
use think\model\concern\SoftDelete;

class Admin extends Model
{
    //软删除
    use SoftDelete;
    //登录校验
    public function login($data) {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
        }
        $result = $this->where($data)->find();
        if ($result) {
            //判断用户是否可用
            if ($result['status'] != 1) {
                return '此账户已禁用！';
            }
            //1表示有这个用户，表示用户名和密码正确
            //设置session
            $sessionData = [
                'id'        =>  $result['id'],
                'nickname'  =>  $result['nickname'],
                'email'     =>  $result['email'],
                'is_super'  =>  $result['is_super']
            ];
            Session::set('admin', $sessionData);
            return 1;
        }else {
            return '用户名或密码错误~';
        }
    }
    //注册验证
    public function register($data) {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('register')->check($data)) {
            return $validate->getError();
        }
        //新增数据
        $result = $this->allowField(true)->save($data);
        if ($result) {
            mailto($data['email'], '注册管理员账户成功', '注册管理员账户成功！');
            return 1;
        }else {
            return '注册失败~';
        }
    }
    //重置密码验证
    public function reset($data) {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('reset')->check($data)) {
            return $validate->getError();
        }
        //判断验证码是否正确
        if ($data['code'] != Session::get('code')) {
            return '验证码错误~';
        }
        //更新成随机密码
        $admin = $this->where('email', $data['email'])->find();
        $password = mt_rand(10000,99999);
        $admin->password = $password;
        $result = $admin->save();
        if ($result) {
            //更新成功，发送邮件
            $content = '恭喜你重置密码成功！<br>'.'您的用户名为：'.$admin['username'].'<br>新密码为：'.$password;
            mailto($data['email'], '密码重置成功', $content);

            return 1;
        }else {
            return '密码重置失败~';
        }
    }

    //管理员添加操作
    public function add($data) {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('add')->check($data)) {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        }else {
            return '管理员添加失败！';
        }
    }

    //管理员编辑操作
    public function edit($data) {
        $validate = new \app\common\validate\Admin();
        if (!$validate->scene('edit')->check($data)) {
            return $validate->getError();
        }

        //根据id查询
        $admin = $this->where('id', $data['id'])->find();

        if ($data['oldPass'] != null && $data['oldPass'] != $admin['password']) {
            return '旧密码错误！';
        }elseif ($data['oldPass'] == null && $data['newPass'] != null) {
            return '旧密码错误！';
        }elseif ($data['oldPass'] != null && $data['newPass'] == null) {
            return '新密码不能为空！';
        }elseif ($data['oldPass'] == null && $data['newPass'] == null) {
            //表示不修改密码
            $admin->nickname = $data['nickname'];
        }else {
            $admin->password = $data['newPass'];
            $admin->nickname = $data['nickname'];
        }
        $result = $admin->save();
        if ($result) {
            return 1;
        }else {
            return '编辑管理员失败！';
        }
    }

}
