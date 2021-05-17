<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class System extends Model
{
    //软删除
    use SoftDelete;

    //系统编辑验证
    public function edit($data) {
        $validate = new \app\common\validate\System();
        if (!$validate->check($data)) {
            return $validate->getError();
        }
        $system = $this->where('id', $data['id'])->find();
        $system->webname = $data['webname'];
        $system->copyright = $data['copyright'];
        $result = $system->save();
        if ($result) {
            return 1;
        }else {
            return '修改失败！';
        }
    }
}
