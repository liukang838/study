<?php
/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2018/10/24
 * Time: 下午11:20
 */


$dsn = 'mysql:dbname=test;host=127.0.0.1';
$username = 'liukang_rw';
$pwd = 'kang1314';

try {
    $attr = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ];

    $pdo = new PDO($dsn, $username, $pwd);

//    $sql = 'insert into article (content) values (:content)';
    $sql = 'select * from article where content=:content';

//    //预处理语句
    $tmt = $pdo->prepare($sql);
    $tmt->execute([':content' => "鬼刀一开，走位走位"]);
    var_dump($tmt->fetchAll());exit;


    $rows = $tmt->rowCount();
    if ($rows) {
        exit('添加成功啦~' . PHP_EOL);
    } else {
        exit('添加失败啦' . PHP_EOL);
    }

} catch (\Exception $e) {
    var_dump($e->getMessage());
}


