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
        $id = $request->input('id');
        if (empty($id)) return $this->codeReturn(StatusCode::FAIL, null, '参数不正确');
        $ret = EsArticleModel::getInstance()->findBy($id);

        return $this->codeReturn(StatusCode::SUCCESS, $ret);
    }
}
