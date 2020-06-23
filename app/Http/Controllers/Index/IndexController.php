<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;
use Illuminate\Support\Facades\Cookie;
class IndexController extends Controller
{
    // 前台注册
    public function reg()
    {
        return view('index.reg');
    }

    // 前台登录
    public function login()
    {
        return view('index.login');
    }
    
    // 用户注册逻辑
    public function regdo(Request $request)
    {
        // 接收值
        $user_name=$request->input('user_name');
        $user_email=$request->input("user_email");
        $password=$request->input("password");
        $passwords=$request->input("passwords");
       
        // 验证密码长度
        $str= strlen($password);
        if($str<6){
            die('密码长度必须是6位以上');
        }

        // 验证密码和确认密码
        if($passwords !=$password){
            die("密码和确认密码不一致,请重新输入");
        }

        // 验证邮箱
        if(!$user_email){
            die("邮箱不能为空");
        }

        // 检测用户是否存在
        $res=UserModel::where(['user_name'=>$user_name])->first();
        if($res){
            die("用户已存在");
        }

         // 检测邮箱是否存在
         $res1=UserModel::where(['user_email'=>$user_email])->first();
         if($res1){
             die("邮箱已存在");
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
         var_dump($user);
    }

    // 用户登录逻辑
    public function logindo(Request $request)
    {
        $user_name=$request->input('user_name');
        $password=$request->input('password');

        // 验证登录信息
        $user=UserModel::where(['user_name'=>$user_name])->first();
        // echo '数据库的密码:' .$user->password;echo '</br>';

        // 验证密码
        $res=password_verify($password,$user->password);
        if($res){
            // 向客户端设置cookie
            // setcookie('uid',$user->user_id,time()+3600,'/');
            setcookie('name',$user->user_name,time()+3600,'/');
            Cookie::queue('uid',$user->user_id,10);
            echo "登录成功";
            header('Refresh:2;url=/user/center');
        }else{
            header('Refresh:2;url=/user/login');
            echo "用户名与密码不一致,请重新登录";
        }
    }

    // 用户中心
    public function center()
    {
        // 判断用户是否登录,判断是否有uid和name字段
        // echo '<pre>';print_r($_COOKIE);echo '</pre>';

        if(Cookie::has('uid')){
            return view('index/center');
        }else{
            echo "未登录";
            return redirect('user/login');
        }
    }
}
