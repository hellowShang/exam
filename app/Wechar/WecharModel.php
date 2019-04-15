<?php

namespace App\Wechar;

use Illuminate\Database\Eloquent\Model;

class WecharModel extends Model
{
    // 指定表名
    protected $table = 'exam';

    // 关闭时间戳
    public $timestamps = false;
}
