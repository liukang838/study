<?php

namespace App\Http\Controllers;

use App\Http\StatusCode\StatusCode;
use App\Models\UserModel;
use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;

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
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        if (empty($username) || empty($password)) return $this->codeReturn(StatusCode::DATA_VALIDATE_FAIL);

        $user = UserModel::getInstance()->getUserByName($username, $password);
        if (is_null($user)) return $this->codeReturn(StatusCode::NO_PERMISSIONS);

        $is = \Hash::check($password, $user->password);
        if (!$is) return $this->codeReturn(StatusCode::NO_PERMISSIONS);

        $token = \Auth::guard($this->guard)->login($user);

        if (!$token) return $this->codeReturn(StatusCode::NO_PERMISSIONS);
        $user->token = $token;
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
