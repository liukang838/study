<?php

namespace App\Servers\Auth\Factory;

use App\Servers\Auth\EmailAuth;

/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2019/8/7
 * Time: 下午4:30
 */
class EmailAuthFactory implements AuthFactory
{
    public static function createAuth($email, $password)
    {
        return new EmailAuth($email, $password);
    }
}
