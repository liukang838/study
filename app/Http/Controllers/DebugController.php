<?php

namespace App\Http\Controllers;

use App\Http\StatusCode\StatusCode;

class DebugController extends Controller
{
    /**
     *  测试用api接口
     *
     * @return array
     * @throws \Exception
     */
    public function index()
    {
        $ret = \DB::connection('mysql')->table('article')->first();
        return $this->codeReturn(StatusCode::SUCCESS, $ret);
    }
}
