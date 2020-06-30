<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class TestController extends Controller
{
    public function hello()
    {
        echo __METHOD__;echo '</br>';
        echo date('Y-m-d h:i:s');
    }

    public function test1()
    {
       $data=[
           'name'=>'lisi',
           'age'=>'20'
       ];
       return $data;
    }


    //签名测试   发送数据
    public function sign1()
    {
        $key='1910';
        $data='hello world';
        $sign=md5($data.$key);    //生成签名

        echo "要发送的数据: ".$data;echo '</br>';
        echo "发送前生成的签名 ".$sign;echo '<hr>';

        // 将数据和签名发送到对端
        $url='http://www.1910.com/secret?data='.$data.'&sign='.$sign;
        echo $url;
    }


    // 接收数据
    public function secret()
    {
        $key='1910';
        echo '<pre>'; print_r($_GET);echo '</pre>';
        // 收到数据 验证签名
        $data=$_GET['data'];  //接收到的数据
        $sign=$_GET['sign'];  //接收的签名

        $loca_sign=md5($data.$key);   //验签算法 与 发送端的生成验签算法保持一致 data+key
        echo '本地计算的签名:' .$loca_sign;echo '</br>';

        if($sign==$loca_sign){
            echo "验签通过";
        }else{
            echo "验签失败";
        }

    }


    public function www()
    {
        $key='1910';
        $url='http://api.1910.com/api/info';

       // 向api接口发送数据
        // get方式发送
        $data='hello';
        $sign=sha1($data.$key);
        $url=$url . '?data='.$data.'&sign='.$sign;

        // php发起网路请求
        $response=file_get_contents($url);
        echo $response;
    }



    public function sendData()
    {
       $url='http://api.1910.com/test/receive?name=zhangsan&age=10';  //要调用的接口地址
        $response=file_get_contents($url);
        echo $response;
    }


    //向接口post数据 
    public function postData()
    {
        $data= [
            'user_name'=>'wangwu',
            'user_age'=>333
        ];

        

        $url='http://api.1910.com/test/receive-post';
        // 使用curl post数据
        // 1.实例化
        $ch=curl_init();

        // 2.配置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);  //使用post方式
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

        // 3.开启会话
       $response= curl_exec($ch);

        // 4.检测错误
        $errno=curl_errno($ch);  //错误码
        $errmsg=curl_error($ch);
        
        if($errno){
            echo '错误码:'.$errno;echo '</br>';
            var_dump($errmsg);die;
        }

        curl_close($ch);
        echo $response;
    }


    // 对称加密
    public function encrypt1()
    {
        $data='长江,长江,我是黄河'; 
        $method='AES-256-CBC';    //加密算法
        $key='1910api';   //加密秘钥
        $iv='hellohelloABCDEF';   //初始向量

        // 加密数据
        $enc_data=openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);

        $sign=sha1($enc_data.$key);  //签名

        // echo "加密的密文:".$enc_data;echo '</br>';

        // 组合post的数据
        $post_data=[
            'data'=>$enc_data,
            'sign'=>$sign
        ];

        // 将密文发送至对端 post
        $url='http://api.1910.com/test/decrypt1';
        // 使用curl post数据
        // 1.实例化
        $ch=curl_init();

        // 2.配置参数
        curl_setopt($ch,CURLOPT_URL,$url);  //post地址
        curl_setopt($ch,CURLOPT_POST,1);  //使用post方式发送数据
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);  //post的数据
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  //通过变量接收响应

        // 3.开启会话 （发送请求）
       $response= curl_exec($ch);  //接收响应
       echo $response;

        // 4.捕捉错误
        $errno=curl_errno($ch);  //错误码
        if($errno){
            $errmsg=curl_error($ch);
            var_dump($errmsg);die;
        }


        // 关闭连接

        curl_close($ch);

    }
}
