<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
class TestController extends Controller
{
    public function a()
    {
      echo "访问了a方法";
    }

    public function b()
    {
        echo __METHOD__;
    }

    public function c()
    {
        echo __METHOD__;
    }
}
