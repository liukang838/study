<?php

namespace App\Http\Controllers;

use App\Es\EsArticleModel;
use App\Http\StatusCode\StatusCode;
use App\Models\ArticleModel;
use App\Models\UserModel;
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
        //邮箱的正则
        $str = '971909657i@qq.com';
        $pattern = '/[\w]+@.[\w]+\.[\w]+/';
//        $str = preg_replace($pattern, '\\1', $str);
        preg_match($pattern, $str, $ret);
        dd($ret);

        return $this->codeReturn(StatusCode::SUCCESS);

//        $c=['iss' => 1, 'iat' => 1, 'exp' => 100, 'nbf' => 111, 'sub' => 1, 'jti' => 1];
//
//        $str = UserModel::getInstance()->getToken($c);
//        return $this->codeReturn(StatusCode::SUCCESS, $str);
//
//        $result = ArticleModel::get();
//
//        try {
//
//            $dsn = 'mysql:dbname=test;host=127.0.0.1';
//            $username = 'liukang_rw';
//            $pwd = 'kang1314';
//
//            $pdo = new PDO($dsn, $username, $pwd);
//
////    $sql = 'insert into article (content) values (:content)';
//            $sql = 'select * from article where content=:content';
//
////    //预处理语句
//            $tmt = $pdo->prepare($sql);
//            $tmt->execute([':content' => "鬼刀一开，走位走位"]);
//
//        } catch (\Exception $e) {
//        }

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
        $ret = EsArticleModel::getInstance()->findBy(99);

        return $this->codeReturn(StatusCode::SUCCESS, $ret);
    }

}
