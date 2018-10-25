<?php

namespace App\Http\Controllers;

use App\Http\StatusCode\StatusCode;

class DebugController extends Controller
{
    public function index()
    {
//        dd(getenv('DB_HOST'));
        $ret = \DB::connection('mysql')->table('article')->first();

        return $this->codeReturn(StatusCode::SUCCESS, $ret);
    }
}
