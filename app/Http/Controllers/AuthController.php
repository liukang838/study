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

        $token = \Auth::guard('api')->login($user);

        if (!$token) return $this->codeReturn(StatusCode::NO_PERMISSIONS);
        $user->token = $token;
        return $this->codeReturn(StatusCode::SUCCESS, $user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     * 刷新token，如果开启黑名单，以前的token便会失效。
     * 值得注意的是用上面的getToken再获取一次Token并不算做刷新，两次获得的Token是并行的，即两个都可用。
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
