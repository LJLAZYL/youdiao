<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2018/11/4
 * Time: 19:33
 */
namespace app\common\model;
use think\Model;

class AdminUser extends Model{

    protected $autoWriteTimestamp =true;
    //新增
    public function add($data){

        if(!is_array($data)){
            exception('传递的数据不合法');
        }
        $this->allowField(true)->save($data);

        return $this->id;
    }
}