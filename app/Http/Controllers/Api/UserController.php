<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Model\UserModel;
use App\Model\TokenModel;
use Illuminate\Support\Facades\Redis;
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

    // 用户登录逻辑
    public function login(Request $request)
    {
        $user_name=$request->input('user_name');
        $password=$request->input('password');

        // 验证登录信息
        $user=UserModel::where(['user_name'=>$user_name])->first();
        // echo '数据库的密码:' .$user->password;echo '</br>';

        // 验证密码
        $res=password_verify($password,$user->password);
        if($res)
        {  
            // 生成token
            $str= $user->user_id . $user->user_name . time();
            $token =substr(md5($str),10,16) . substr(md5($str),0,10);


            // 将token保存在redis中
            Redis::set($token,$user->user_id);

            // 设置key的过期时间
            

            $response=[
                'erron'=>0,
                'msg'=>'ok',
                'token'=>$token
            ];
        }else{
            $response=[
                'erron'=>40007,
                'msg'=>'用户名与密码不一致,请重新登录',
            ];

        }
        return $response;
    }

    // 个人中心
    public function center()
    {
        // 判断用户是否登录,判断是否有uid字段
       if(isset($_GET['token']))
       {
        $token=$_GET['token'];
       }else{
        $response=[
            'erron'=>40008,
            'msg'=>'请先登录'
        ];
        return $response;
       }

        // 检查token是否有效
        $uid=Redis::get($token);

        if($uid)
        {
           
            $user_info=UserModel::find($uid);
            // 已登录
             echo $user_info->user_name ."欢迎来到个人中心";
           }else{
            //    未登录
            $response=[
                'erron'=>40009,
                'msg'=>'请先登录'
            ];
            return $response;
           }
       }

      
    //    我的订单
    public function orders()
    {

        // 鉴权
        if(isset($_GET['token']))
        {
         $token=$_GET['token'];

        //  验证token有效
        $uid=Redis::get($token);
            if($uid)
            {

            }else{
                $response=[
                    'erron'=>40009,
                    'msg'=>'请先登录'
                ];
                return $response;
            }

        }else{
         $response=[
             'erron'=>40008,
             'msg'=>'请先登录'
         ];
         return $response;
        }


        // 订单信息
        $arr=[
            '2345654334553434',
            '2345654123554434',
            '2345654232315434',
            '2345654334554334',
            '2345654323255434'
        ];

        $response=[
            'erron'=>0,
            'msg'=>'ok',
            'data'=>[
                'orders'=>$arr
            ]
        ];
        return $response;
    }

    // 购物车
    public function cart()
    {
        if(!isset($_GET['token'])){
            $response=[
                'erron'=>40009,
                'msg'=>'请先登录'
            ];
            return $response;
        }

         // 鉴权
         $token=$_GET['token'];
        //  验证token有效
        $uid=Redis::get($token);
            if($uid)
            {

            }else{
                $response=[
                    'erron'=>400010,
                    'msg'=>'请先登录'
                ];
                return $response;
            }

        $goods=[
            123,
            456,
            789
        ];

        $response=[
            'erron'=>0,
            'msg'=>'ok',
            'data'=>$goods
        ];
        return $response;
    }
}
