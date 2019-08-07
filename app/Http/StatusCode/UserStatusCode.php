<?php
/**
 * Created by PhpStorm.
 * User: tanfan
 * Date: 2016/10/14
 * Time: 16:47
 */

namespace App\Http\StatusCode;

class UserStatusCode extends StatusCode
{
    const PASSWORD_ERROR = [100001, '密码错误'];
    const USER_UN_EXISTS = [100002, '用户不存在'];
}
