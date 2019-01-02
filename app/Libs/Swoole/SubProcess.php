<?php
/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2018/12/4
 * Time: 下午1:45
 */

function doProcess(swoole_process $worker)
{
    echo "PID:".$worker->pid.PHP_EOL;
    sleep(1);
}

//创建了一个进程
$process= new swoole_process('doProcess',false,false);
$pid = $process->start();
$process= new swoole_process('doProcess',false,false);
$pid = $process->start();
$process= new swoole_process('doProcess',false,false);
$pid = $process->start();
$process= new swoole_process('doProcess',false,false);
$pid = $process->start();

swoole_process::wait();
