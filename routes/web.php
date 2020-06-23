<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    
    return view('welcome');
});

// 测试
Route::get('test/hello','TestController@hello');
Route::get('test/redis1','TestController@redis1'); //redis 测试
Route::get('/test1','TestController@test1'); //redis 测试


Route::get('goods/detail','Goods\GoodsController@detail'); //商品详情
Route::get('goods/goodsinfo','Goods\GoodsController@goodsinfo'); //测试


// 注册
Route::get('user/reg','Index\IndexController@reg'); //前台注册视图路由
Route::post('user/regdo','Index\IndexController@regdo'); //前台注册路由

// 登录
Route::get('user/login','Index\IndexController@login'); //前台登录视图
Route::post('user/logindo','Index\IndexController@logindo'); //前台登录路由


Route::get('user/center','Index\IndexController@center'); //用户中心