<?php

namespace App\Http\Controllers;

use App\Http\StatusCode\StatusCode;
use App\Models\ArticleModel;

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
        $ret = ArticleModel::getInstance()->findBy(2);
        return $this->codeReturn(StatusCode::SUCCESS, $ret);
    }
}
