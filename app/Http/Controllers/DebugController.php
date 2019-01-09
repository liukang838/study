<?php

namespace App\Http\Controllers;

use App\Http\StatusCode\StatusCode;
use App\Models\ArticleModel;
use Illuminate\Http\Request;
use Swoole\Coroutine\MySQL;
use PDO;

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
        $result = ['1123123'];

        $result = ArticleModel::get();


        try {

            $dsn = 'mysql:dbname=test;host=127.0.0.1';
            $username = 'liukang_rw';
            $pwd = 'kang1314';

            $pdo = new PDO($dsn, $username, $pwd);

//    $sql = 'insert into article (content) values (:content)';
            $sql = 'select * from article where content=:content';

//    //预处理语句
            $tmt = $pdo->prepare($sql);
            $tmt->execute([':content' => "鬼刀一开，走位走位"]);

        } catch (\Exception $e) {
        }

//        $mysql = new MySQL;
//        $mysql->connect([
//            'host' => '127.0.0.1',
//            'user' => 'liukang_rw',
//            'password' => 'kang1314',
//            'database' => 'test'
//        ]);
//        $statement = $mysql->prepare('SELECT * FROM `article`');
//
//        $result = $statement->execute();

//        $key = $request->input('key');
//        if (empty($key)) return $this->codeReturn(StatusCode::FAIL, null, '参数不正确');
//
//        $title = $request->input('title');
//        if (empty($key)) return $this->codeReturn(StatusCode::FAIL, null, '参数不正确');
//
//        $params = ['content' => $key, 'title' => $title];
//        $ret = EsArticleModel::getInstance()->search($params);

        return $this->codeReturn(StatusCode::SUCCESS, $result);
    }
}
