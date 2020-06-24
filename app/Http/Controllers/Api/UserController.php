<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;
class UserController extends Controller
{
        // 用户注册
        public function reg(Request $request)
        {
            // 接收值
            $user_name=$request->input('user_name');
            $user_email=$request->input("user_email");
            $password=$request->input("password");
            $passwords=$request->input("passwords");
           
            // 验证密码长度
            $str= strlen($password);
            if($str<6){
                $response=[
                    'errno'=>40001,
                    'msg'=>'密码长度必须大于6'
                ];
                return $response;
            }
    
            // 验证密码和确认密码
            if($passwords !=$password){
                $response=[
                    'errno'=>40002,
                    'msg'=>'两次输入的密码不一致'
                ];
                return $response;
            }
    
            // 检测用户是否存在
            $res=UserModel::where(['user_name'=>$user_name])->first();
            if($res){
                $response=[
                    'errno'=>40003,
                    'msg'=>'用户已存在'
                ];
                return $response;
            }
    
             // 检测邮箱是否存在
             $res1=UserModel::where(['user_email'=>$user_email])->first();
             if($res1){
                $response=[
                    'errno'=>40004,
                    'msg'=>'邮箱已存在'
                ];
                return $response;
             }
    
            //  生成密码
            $password=password_hash($passwords,PASSWORD_BCRYPT);
    
            // 验证通过 添加用户
             $data= [
                'user_name'=>$user_name,
                'user_email'=>$user_email,
                'password'=>$password,
                'reg_time'=>time()
             ];
             
             $user=UserModel::insert($data);
             if($user==true){
                $response=[
                    'errno'=>40005,
                    'msg'=>'注册成功'
                ];
               
             }else{
                $response=[
                    'errno'=>40006,
                    'msg'=>'注册失败'
                ];
                
             }
             return $response;
        }
}
