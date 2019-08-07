<?php

namespace App\Servers\Auth;

use App\Models\UserModel;

/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2019/8/7
 * Time: 下午4:34
 */
class PhoneAuth implements UserAuth
{
    private $phone;
    private $password;
    public $user;

    public function __construct($phone, $password)
    {
        $this->phone = $phone;
        $this->password = $password;
        $this->user = $this->user();
    }

    public function user()
    {
        return UserModel::getInstance()->getUserByPhone($this->phone);
    }

    public function check()
    {
        if (is_null($this->user)) return false;
        return \Hash::check($this->password, $this->user->password);
    }
}
