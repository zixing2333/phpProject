<?php

namespace app\admin\controller;

use think\Controller;

class Member extends Base
{
    //会员列表
    public function list() {
        //查询数据
        $member = new \app\common\model\Member();
        //分页查询
        $memberInfo = $member->order('create_time', 'desc')->paginate(10);
        $this->assign('memberInfo', $memberInfo);

        return $this->fetch('list');
    }
    //会员添加
    public function add() {
        if ($this->request->isAjax()) {
            $data = [
                'username'      =>  $this->request->post('username'),
                'password'      =>  $this->request->post('password'),
                'nickname'      =>  $this->request->post('nickname'),
                'email'         =>  $this->request->post('email'),
            ];
            $member = new \app\common\model\Member();
            $result = $member->add($data);
            if ($result == 1) {
                $this->success('会员添加成功~', 'admin/member/list');
            }else {
                $this->error($result);
            }
        }
        return $this->fetch('add');
    }
    //会员编辑
    public function edit() {
        if ($this->request->isAjax()) {
            $data = [
                'id'            =>  $this->request->post('id'),
                'username'      =>  $this->request->post('username'),
                'oldPass'       =>  $this->request->post('oldPass'),
                'newPass'       =>  $this->request->post('newPass'),
                'nickname'      =>  $this->request->post('nickname'),
                'email'         =>  $this->request->post('email'),
            ];
            $member = new \app\common\model\Member();
            $result = $member->edit($data);
            if ($result == 1) {
                $this->success('会员编辑成功~', 'admin/member/list');
            }else {
                $this->error($result);
            }
        }

        $id = $this->request->param('id');
        $memberInfo = \app\common\model\Member::get($id);
        $this->assign('memberInfo', $memberInfo);

        return $this->fetch('edit');
    }
    //会员删除
    public function del() {
        $id = $this->request->post('id');
        $member = \app\common\model\Member::with('comments')->get($id);
        $result = $member->together('comments')->delete();
        if ($result) {
            $this->success('会员删除成功~', 'admin/member/list');
        }else {
            $this->error('会员删除失败！');
        }
    }
}
