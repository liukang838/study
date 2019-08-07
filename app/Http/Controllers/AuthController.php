<?php

namespace App\Http\Controllers;

use App\Http\StatusCode\StatusCode;
use App\Http\StatusCode\UserStatusCode;
use App\Servers\Auth\Factory\EmailAuthFactory;
use App\Servers\Auth\Factory\PhoneAuthFactory;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $guard = 'api';

    /**
     * Create a new AuthController instance.
     * 要求附带email和password（数据来源users表）
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function loginByPhone(Request $request)
    {
        $phone = $request->input('phone');
        $password = $request->input('password');
        if (empty($phone) || empty($password)) return $this->codeReturn(StatusCode::DATA_VALIDATE_FAIL);

        $phoneFactory = PhoneAuthFactory::createAuth($phone, $password);
        if (is_null($phoneFactory->user)) return $this->codeReturn(UserStatusCode::USER_UN_EXISTS);

        $checkPassword = $phoneFactory->check();
        if (!$checkPassword) return $this->codeReturn(UserStatusCode::PASSWORD_ERROR);

        $user = $phoneFactory->user;
        $token = \Auth::guard($this->guard)->login($user);
        if (!$token) return $this->codeReturn(UserStatusCode::FAIL);
        $user->token = $token;

        unset($user->password);
        return $this->codeReturn(StatusCode::SUCCESS, $user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return array
     * @throws \Exception
     */
    public function logout()
    {
        \Auth::guard($this->guard)->logout();

        return $this->codeReturn(StatusCode::SUCCESS);
    }

    public function getUser()
    {
        return $this->codeReturn(StatusCode::SUCCESS, $this->user());
    }

    /**
     * Refresh a token.
     *
     * @return array
     * @throws \Exception
     */
    public function refresh()
    {
        $token = \Auth::guard($this->guard)->refresh();

        return $this->codeReturn(StatusCode::SUCCESS, $token);
    }
}
