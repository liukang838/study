<?php
/**
 * Created by PhpStorm.
 * User: liukang
 * Date: 2019/3/5
 * Time: 上午10:56
 */
//创建一个socket套接流
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

/****************设置socket连接选项，这两个步骤你可以省略*************/
//接收套接流的最大超时时间1秒，后面是微秒单位超时时间，设置为零，表示不管它
socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 1, "usec" => 0));

//发送套接流的最大超时时间为6秒
socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array("sec" => 6, "usec" => 0));
/****************设置socket连接选项，这两个步骤你可以省略*************/

//连接服务端的套接流，这一步就是使客户端与服务器端的套接流建立联系
if (socket_connect($socket, '127.0.0.1', 8383) == false) {
    echo '连接失败，失败原因：' . socket_strerror(socket_last_error());
} else {
    $message = '卧槽，哈哈哈哈';
    //转为GBK编码，处理乱码问题，这要看你的编码情况而定，每个人的编码都不同
//    $message = mb_convert_encoding($message,'GBK','UTF-8');

    //向服务端写入字符串信息

    if (socket_write($socket, $message, strlen($message)) == false) {
        echo '向服务端写入字符串信息失败，失败原因' . socket_strerror(socket_last_error());
    } else {
        echo '向服务端写入字符串信息成功' . "\n";
        //读取服务端返回来的套接流信息
        while ($callback = socket_read($socket, 1024)) {
            echo '服务器返回的信息是:' . "\n" . $callback;
        }
    }
}
