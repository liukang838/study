<?php

namespace App\Servers\Auth\Factory;

/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2019/8/7
 * Time: 下午4:29
 */
interface AuthFactory
{
    public static function createAuth($account, $password);
}
