<?php

namespace App\Http\Controllers\Wechar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WecharController extends Controller
{
    // 首次接入
    public function first(){
        echo $_GET['echostr'];
    }

    // 扫码事件
    public function sweep(){
        // 接收数据并写入log日志中
        $xml = file_get_contents('php://input');
        $time  = time();
        $str = $time.$xml.'\n';
        is_dir('logs') or mkdir('logs',0777,true);
        file_put_contents('logs/wechar.log',$str,FILE_APPEND);


    }
}
