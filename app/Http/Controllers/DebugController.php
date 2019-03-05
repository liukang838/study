<?php

namespace App\Http\Controllers;

use App\Es\EsArticleModel;
use App\Http\StatusCode\StatusCode;
use App\Models\ArticleModel;
use App\Models\Kafka;
use App\Models\KafkaModel;
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

    /**
     * @return array
     * @throws \Exception
     */
    public function sort(Request $request)
    {
        dd($this->test($request->input('c')));
        $arr = [];
        for ($i = 1; $i <= 1000000; $i++) {
            $arr[] = mt_rand(1, 100000000000);
        }
        sort($arr);
        $count = count($arr);

        $ret = $this->quicklySearch($arr, 12312231233, 0, $count - 1);

        return $this->codeReturn(StatusCode::SUCCESS, $ret);


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

//        //选择排序
//        for ($i = 0; $i < $count - 1; $i++) {
//            $min = $arr[$i];
//            $minIndex = $i;
//            for ($j = $i + 1; $j < $count; $j++) {
//                if ($min > $arr[$j]) {
//                    $min = $arr[$j];
//                    $minIndex = $j;
//                }
//            }
//            $tmp = $arr[$i];
//            $arr[$i] = $arr[$minIndex];
//            $arr[$minIndex] = $tmp;
//        }

        //插入排序
//        for ($i = 1; $i < $count; $i++) {
//            $insert = $arr[$i];
//            $j = $i - 1;
//            //寻找插入的位置
//            for (; $j >= 0; $j--) {
//                if ($arr[$j] > $insert){
//                    $arr[$j + 1] = $arr[$j];
//                }else{
//                    break;
//                }
//            }
//            $arr[$j + 1] = $insert;
//        }

        //快速排序
//        $arr = $this->quicklySort($arr);

        return $this->codeReturn(StatusCode::SUCCESS, $arr);

    }

    public function quicklySearch(array $arr, $num, $start, $end)
    {


        if ($start > $end) return false;

        $mid = floor(($start + $end) / 2);
        if ($arr[$mid] == $num) {
            return $mid;
        } else if ($arr[$mid] > $num) {
            return $this->quicklySearch($arr, $num, $start, $mid - 1);
        } else {
            return $this->quicklySearch($arr, $num, $mid + 1, $end);
        }

    }

    public function quicklySort($array)
    {
        if (!isset($array[1])) return $array;

        $mid = $array[0];
        $left = $right = [];
        foreach ($array as $value) {
            if ($mid > $value) {
                $left[] = $value;
            }
            if ($mid < $value) {
                $right[] = $value;
            }
        }
        $leftArr = $this->quicklySort($left);
        $leftArr[] = $mid;
        $rightArr = $this->quicklySort($right);
        return array_merge($leftArr, $rightArr);

    }

    public function test($c)
    {
        return call_user_func(function ($a, $p) use ($c) {
            return [
                'a' => $a,
                'b' => $p,
                'c' => $c
            ];
        }, $c);
    }

    public function production()
    {
        $ret = KafkaModel::getInstance()->sendMessage(['fuck you mom!']);
        return $this->codeReturn(StatusCode::SUCCESS, $ret);
    }

}
