<?php

namespace App\Servers\Auth;
/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2019/8/7
 * Time: 下午4:33
 */
interface UserAuth
{
    public function check();

    public function user();
}
