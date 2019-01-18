<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $guard;

    public function codeReturn($statusCode, $data = null, $info = '')
    {
        if (!isset($statusCode[0]) || !isset($statusCode[1])) {
            throw new \Exception('Unknow status code!');
        }

        $result = ['code' => $statusCode[0], 'msg' => $statusCode[1], 'info' => $info, 'data' => $data];

        return $result;
    }

    public function user()
    {
        if (empty($this->guard)) {
            return null;
        }
        return \Auth::guard($this->guard)->user();
    }
}
