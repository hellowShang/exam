<?php

namespace App\Http\Controllers\Wechar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Wechar\WecharModel;
use Illuminate\Support\Facades\Redis;

class WecharController extends Controller
{
    // 首次接入
    public function first(){
        echo $_GET['echostr'];
    }

    // 扫码事件
    public function sweep(){
        // 接收数据并写入log日志中
        $data = file_get_contents('php://input');
        $time  = date('Y-m-d H:i:s',time());
        $str = $time.$data."\n";
        is_dir('logs') or mkdir('logs',0777,true);
        file_put_contents('logs/wechar.log',$str,FILE_APPEND);

        // 获取用户基本信息入库
        $xml = simplexml_load_string($data);
        $openid = $xml-> FromUserName;
        $userInfo = $this-> getUserInfo($openid);
        file_put_contents('logs/wechar.log',$userInfo,FILE_APPEND);


        $this-> addUserInfo($xml,$openid);


    }

    // 获取access_token
    public function getAccessToken()
    {
        $key = 'access_token';
        $token = Redis::get($key);
        if ($token) {
        } else{
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=env('WECHAR_APPID')&secret=env('WECHAR_SECRET')";
            $token = file_get_contents($url);
            Redis::set($key,$token);
            Redis::expire($key,3600);
         }
         return $token;
    }

    // 获取用户基本信息
    public function getUserInfo($openid){
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->getAccessToken()."&openid=".$openid."&lang=zh_CN";
        $data = file_get_contents($url);
        $arr = json_decode($data,true);
        return $arr;
    }

    // 用户信息入库
    public function addUserInfo($xml,$openid){
        if($xml->MsgType == 'event' && $xml->Event == 'subscribe'){
            $arr = WecharModel::where('openid',$openid)->first();
            if($arr){

            }else{
                $info = [
                    'subscribe' => $userInfo['subscribe'],
                    'openid' => $userInfo['openid'],
                    'nickname' => $userInfo['nickname'],
                    'sex' => $userInfo['sex'],
                    'city' => $userInfo['city'],
                    'province' => $userInfo['province'],
                    'country' => $userInfo['country'],
                    'headimgurl' => $userInfo['headimgurl'],
                    'subscribe_time' => $userInfo['subscribe_time'],
                ];

                $message = "";
            }
        }
    }
}
