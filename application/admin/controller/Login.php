<?php
namespace app\admin\controller;

use think\Controller;
use app\common\validate\AdminUser;
use app\common\lib\IAuth;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    //登陆相关业务
    public function check(){
        if(request()->isPost()){
            $data = input('post.');
            if(!captcha_check($data['code'])){
                $this->error('验证码不正确');
            }

            //判定username password
            $validate = validate('AdminUser');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }

            try {
                //username
                $user = model('AdminUser')->get(['username' => $data['username']]);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }

            if(!$user || $user->status != config('code.status_normal')){
                $this->error('该用户不存在');
            }

            //对密码进行校验
            if(IAuth::setPassword($data['password']) != $user['password']){
                $this->error('密码不正确');
            }

            //1、更新数据库：登陆时间、登陆ip
            $udata = [
                'last_login_time' => time(),
                'last_login_ip' =>request()->ip(),
            ];

            try{
                model('AdminUser')->save($udata, ['id' => $user->id]);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }

            //2、session
            session(config('admin.session_user'),$user,config('admin.session_user_scope'));
            $this->success('登陆成功','index/index');
        }else{
            $this->error('请求不合法');
        }

    }

}
