<?php
namespace app\admin\controller;

use app\common\lib\IAuth;
use app\common\model\AdminUser;
use think\Controller;
use think\Request;

class Admin extends Controller
{
    public function add()
    {
        //判断是否是post提交
        if(Request()->isPost()){
            //打印数据
            //dump(input('post.'));   halt();  =>  dump(); exit()
            $data = input('post.');
            //validate
            $validate = validate('AdminUser');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }

            $data['password'] = IAuth::setPassword($data['password']);
            $data['status'] = 1;

            //1 exception
            //2 add id
            try{
                $id = model('AdminUser')->add($data);
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }

            if($id){
                $this->success('id='.$id.'的用户新增成功');
            }else{
                $this->error('error');
            }

        }else{
            return $this->fetch();
        }
    }
}
