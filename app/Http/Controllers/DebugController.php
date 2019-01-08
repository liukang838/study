<?php

namespace App\Http\Controllers;

use App\Es\EsArticleModel;
use App\Http\StatusCode\StatusCode;
use Illuminate\Http\Request;

class DebugController extends Controller
{
    /**
     *  测试用api接口
     *
     * @return array
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $ret = ['1123123'];

//        $key = $request->input('key');
//        if (empty($key)) return $this->codeReturn(StatusCode::FAIL, null, '参数不正确');
//
//        $title = $request->input('title');
//        if (empty($key)) return $this->codeReturn(StatusCode::FAIL, null, '参数不正确');
//
//        $params = ['content' => $key, 'title' => $title];
//        $ret = EsArticleModel::getInstance()->search($params);

        return $this->codeReturn(StatusCode::SUCCESS, $ret);
    }
}
