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
Route::prefix('/test')->group(function(){
    Route::get('/hello','TestController@hello');
    Route::get('/sign1','TestController@sign1');
    Route::get('/www','TestController@www');
    Route::get('/sendData','TestController@sendData');
    Route::get('/post-data','TestController@postData');
    Route::get('/encrypt1','TestController@encrypt1');  //对称加密
    Route::get('/rsa/encrypt1','TestController@rsaEncrypt1');  //非对称加密
    Route::get('/rsa/send-b','TestController@sendB');
});



Route::get('/test1','TestController@test1'); //redis 测试
Route::get('/secret','TestController@secret');



Route::get('goods/detail','Goods\GoodsController@detail'); //商品详情
Route::get('goods/goodsinfo','Goods\GoodsController@goodsinfo'); //测试


// 注册
Route::get('user/reg','Index\IndexController@reg'); //前台注册视图路由
Route::post('user/regdo','Index\IndexController@regdo'); //前台注册路由

// 登录
Route::get('user/login','Index\IndexController@login'); //前台登录视图
Route::post('user/logindo','Index\IndexController@logindo'); //前台登录路由


Route::get('user/center','Index\IndexController@center'); //用户中心



// api
Route::post('api/user/reg','Api\UserController@reg'); //注册
Route::post('api/user/login','Api\UserController@login'); //登录
Route::get('api/user/center','Api\UserController@center')->middleware('check.pri'); //个人中心
Route::get('api/my/orders','Api\UserController@orders')->middleware('check.pri'); //我的订单
Route::get('api/my/cart','Api\UserController@cart')->middleware('check.pri'); //购物车


// 路由分组
Route::middleware('check.pri','access.filter')->group(function(){
    Route::get('/api/a','Api\TestController@a'); //测试a
    Route::get('/api/b','Api\TestController@b'); //测试b
    Route::get('/api/c','Api\TestController@c'); //测试c
});
