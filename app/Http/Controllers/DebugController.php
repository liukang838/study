<?php

namespace App\Http\Controllers;

use App\Http\StatusCode\StatusCode;
use Content\Start\Study;

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
        $service=new Study();
        $result=$service->index();

        $ret = \DB::connection('mysql')->table('article')->first();
        return $this->codeReturn(StatusCode::SUCCESS, $ret);
    }
}
