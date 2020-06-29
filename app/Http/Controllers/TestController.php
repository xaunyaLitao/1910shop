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
}
