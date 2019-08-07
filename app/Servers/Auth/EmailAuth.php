<?php

namespace App\Servers\Auth;

use App\Models\UserModel;

/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2019/8/7
 * Time: 下午4:35
 */
class EmailAuth implements UserAuth
{
    private $email;
    private $password;
    public $user;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
        $this->user = $this->user();
    }

    public function user()
    {
        //检查账号是否存在
        return UserModel::getInstance()->getUserByEmail($this->email);
    }

    public function check()
    {
        if (is_null($this->user)) return false;
        return \Hash::check($this->password, $this->user->password);
    }
}
