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

    // redis测试
    public function redis1()
    {
        $key="name1";
        $val1 = Redis::get($key);
        echo '$val1: '.$val1;
    }

    public function test1()
    {
       $data=[
           'name'=>'lisi',
           'age'=>'20'
       ];
       return $data;
    }
}
