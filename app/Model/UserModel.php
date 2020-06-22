<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    public $table='p_users';  //声明使用的表
    protected $primarykey = 'user_id';  //声明表的主键
}
