<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2018/11/4
 * Time: 22:08
 */
namespace app\common\lib;
//IAuth
class IAuth {

    //设置密码
    public static function setPassword($data){

        return md5($data.config('app.password_pre_halt'));
    }
}