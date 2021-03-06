<?php

namespace app\common\model;

use think\facade\Session;
use think\Model;
use think\model\concern\SoftDelete;

class Member extends Model
{
    //软删除
    use SoftDelete;
    //只读字段
    protected $readonly = ['username', 'email'];

    //关联评论
    public function comments() {
        return $this->hasMany('Comment', 'member_id', 'id');
    }

    //会员添加,并验证
    public function add($data) {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('add')->check($data)) {
            return $validate->getError();
        }
        //添加操作
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        }else {
            return '会员添加失败！';
        }
    }

    //会员编辑，并验证
    public function edit($data) {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('edit')->check($data)) {
            return $validate->getError();
        }

        $memberInfo = $this->where('id', $data['id'])->find();
        //判断输入的原密码是否正确
        if ($data['oldPass'] != null && $data['oldPass'] != $memberInfo['password']) {
            return '原密码错误！';
        }elseif ($data['oldPass'] == null && $data['newPass'] != null) {
            return '原密码错误！';
        }elseif ($data['oldPass'] != null && $data['newPass'] == null) {
            return '新密码不能为空！';
        }elseif ($data['oldPass'] == null && $data['newPass'] == null) {
            //判断是否不修改密码
            $memberInfo->nickname = $data['nickname'];
        }else {
            $memberInfo->password = $data['newPass'];
            $memberInfo->nickname = $data['nickname'];
        }
        $result = $memberInfo->save();
        if ($result) {
            return 1;
        }else {
            return '会员编辑失败！';
        }

     }

     //用户注册，并验证
    public function register($data) {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('register')->check($data)) {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        }else {
            return '注册失败！';
        }
    }

    //用户登录，并验证
    public function login($data) {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
        }
        unset($data['verify']);

        $result = $this->where($data)->find();
        if ($result) {
            $sessionData = [
                'id'        =>  $result['id'],
                'nickname'  =>  $result['nickname']
            ];
            Session::set('userInfo', $sessionData);
            return 1;
        }else {
            return '用户名或密码错误';
        }
    }
}
