<?php

namespace app\admin\controller;


class Admin extends Base
{
    //管理员列表
    public function list() {
        $admin = \app\common\model\Admin::order(['is_super'=>'desc', 'status'=>'desc'])->paginate(10);
        $this->assign('admin', $admin);

        return $this->fetch('list');
    }

    //管理员添加
    public function add() {
        if ($this->request->isAjax()) {
            $data = [
                'username'      =>  $this->request->post('username'),
                'password'      =>  $this->request->post('password'),
                'conPass'       =>  $this->request->post('conPass'),
                'nickname'      =>  $this->request->post('nickname'),
                'email'         =>  $this->request->post('email'),
            ];
            $admin = new \app\common\model\Admin();
            $result = $admin->add($data);
            if ($result == 1) {
                $this->success('管理员添加成功~', 'admin/admin/list');
            }else {
                $this->error($result);
            }
        }
        return $this->fetch('add');
    }

    //管理员的启用和禁用
    public function status() {
        $id = $this->request->post('id');
        $status = $this->request->post('status') ? 0 : 1;

        $admin = \app\common\model\Admin::get($id);
        $admin->status = $status;
        $result = $admin->save();
        if ($result) {
            $this->success('操作成功~', 'admin/admin/list');
        }else {
            $this->error('操作失败！');
        }
    }

    //管理员编辑
    public function edit() {
        if ($this->request->isAjax()) {
            $data = [
                'id'            =>  $this->request->post('id'),
                'username'      =>  $this->request->post('username'),
                'oldPass'       =>  $this->request->post('oldPass'),
                'newPass'       =>  $this->request->post('newPass'),
                'nickname'      =>  $this->request->post('nickname'),
                'email'         =>  $this->request->post('email')
            ];
            $admin = new \app\common\model\Admin();
            $result = $admin->edit($data);
            if ($result == 1) {
                $this->success('编辑管理员成功~', 'admin/admin/list');
            }else {
                $this->error($result);
            }
        }

        $id = $this->request->param('id');
        $adminInfo = \app\common\model\Admin::get($id);
        $this->assign('adminInfo', $adminInfo);

        return $this->fetch('edit');
    }

    //删除管理员
    public function del() {
        $id = $this->request->post('id');
        $admin = \app\common\model\Admin::get($id);
        $result = $admin->delete();
        if ($result) {
            $this->success('删除管理员成功~', 'admin/admin/list');
        }else {
            $this->error('删除管理员失败！');
        }
    }
}
