<?php

namespace App\Servers\Auth\Factory;

use App\Servers\Auth\PhoneAuth;

/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2019/8/7
 * Time: 下午4:30
 */
class PhoneAuthFactory implements AuthFactory
{
    public static function createAuth($phone, $password)
    {
        return new PhoneAuth($phone, $password);
    }
}
