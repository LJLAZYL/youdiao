<?php
/**
 * Created by PhpStorm.
 * User: ljl
 * Date: 2018/10/30
 * Time: 22:55
 */

namespace app\common\validate;
use think\validate;

class AdminUser extends validate{

    protected $rule = [
        'username' => 'require|max:20',
        'password' => 'require|max:20',
    ];
}