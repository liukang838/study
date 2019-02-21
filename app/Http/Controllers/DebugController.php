<?php

namespace App\Http\Controllers;

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
        $c = ['iss' => 1, 'iat' => 1, 'exp' => 100, 'nbf' => 111, 'sub' => 1, 'jti' => 1];

        $str = UserModel::getInstance()->getToken($c);
        return $this->codeReturn(StatusCode::SUCCESS, $str);

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

    /**
     * @return array
     * @throws \Exception
     */
    public function sort()
    {
        $arr = [3, 8, 6, 1, 9, 11, 2, 7, 4, 2, 32, 88, 56, 25, 46, 47, 99, 44, 2523, 2, 456, 2312];



        $count = count($arr);
        //冒泡排序 每外层循环一次就将最大的数放在最后
//        for ($i = 1; $i < $count; $i++) {
//            for ($j = 0; $j < $count - $i; $j++) {
//                if ($arr[$j] > $arr[$j + 1]) {
//                    $tmp = $arr[$j + 1];
//                    $arr[$j + 1] = $arr[$j];
//                    $arr[$j] = $tmp;
//                }
//            }
//        }

        //选择排序
        for ($i = 0; $i < $count - 1; $i++) {
            $min = $arr[$i];
            $minIndex = $i;
            for ($j = $i + 1; $j < $count; $j++) {
                if ($min > $arr[$j]) {
                    $min = $arr[$j];
                    $minIndex = $j;
                }
            }
            $tmp = $arr[$i];
            $arr[$i] = $arr[$minIndex];
            $arr[$minIndex] = $tmp;
        }

        return $this->codeReturn(StatusCode::SUCCESS, $arr);

    }

}
