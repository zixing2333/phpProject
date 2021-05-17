<?php

namespace app\admin\controller;

class System extends Base
{
    //系统设置
    public function set() {
        if ($this->request->isAjax()) {
            $data = [
                'id'            =>  $this->request->post('id'),
                'webname'       =>  $this->request->post('webname'),
                'copyright'     =>  $this->request->post('copyright')
            ];
            $system = new \app\common\model\System();
            $result = $system->edit($data);
            if ($result == 1) {
                $this->success('修改成功~', 'admin/system/set');
            }else {
                $this->error($result);
            }
        }

        //查询数据，并传给页面
        $system = \app\common\model\System::find();
        $this->assign('system', $system);

        return $this->fetch('set');
    }
}
