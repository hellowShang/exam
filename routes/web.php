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

// 首次接入
Route::get('/weixin/valid','Wechar\WecharController@first');

// 扫码
Route::post('/weixin/valid','Wechar\WecharController@sweep');

// 获取access_token
Route::get('/weixin/access_token','Wechar\WecharController@getAccessToken');

// 自定义菜单
Route::get('/menu','Wechar\WecharController@menu');
