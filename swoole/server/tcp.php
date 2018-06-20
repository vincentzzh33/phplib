<?php
//namespace swoole;
//
//class tcp{
//
//}

$serv = new swoole_server("0.0.0.0", 9501);

$serv->set([
//    'reactor_num' => 2, //reactor thread num
    'worker_num' => 4,    //worker process num cpu核心数的1到4倍
//    'backlog' => 128,   //listen backlog
    'max_request' => 5000,
//    'dispatch_mode' => 1,
]);


/**
 * $fd是客户端连接的唯一标识
 * $reactor_id 线程
 */
$serv->on('connect', function ($serv, $fd, $reactor_id){
    echo "[#".posix_getpid()."]\tClient@[$fd:$reactor_id]: Connect.\n";
});

//监听发送的数据
//$data 客户发过来的数据
$serv->on('receive', function ($serv, $fd, $reactor_id, $data) {
    echo "[#".$serv->worker_id."]\tClient[$fd:$reactor_id]: $data\n";
    if ($serv->send($fd, "hello\n") == false)
    {
        echo "error\n";
    }
});

//监听关闭事件
$serv->on('close', function ($serv, $fd, $reactor_id) {
    echo "[#".posix_getpid()."]\tClient@[$fd:$reactor_id]: Close.\n";
});

$serv->start();
