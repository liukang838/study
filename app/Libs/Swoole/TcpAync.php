<?php
/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2018/12/3
 * Time: 下午5:37
 */


//创建server
$server = new swoole_server("0.0.0.0", 9501);

//设置异步任务的工作数量
$server->set(['task_worker_num' => 4]);

$server->on('receive', function ($server, $fd, $from_id, $data) {
    //投递任务
    $task_id = $server->task($data);
    echo "Dispath AsyncTask: id=$task_id\n";
});

$server->on('task', function ($server, $task_id, $from_id, $data) {
    echo "New AsyncTask[id=$task_id]" . PHP_EOL;
    //返回任务执行的结果
    $server->finish("$data -> OK");
});

$server->on('finish', function ($server, $task_id, $data) {
    echo "AsyncTask[$task_id] Finish: $data" . PHP_EOL;
});

$server->start();
