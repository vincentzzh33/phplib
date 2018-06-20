<?php
/**
 * Created by Vincent ZHANG.
 * Date: 2018-04-18 0018
 * Time: 14:44
 * Description:
 */

$host = "0.0.0.0";
$port = 8812;
$server = new swoole_websocket_server($host ,$port);

$server->set([
    'enable_static_handler'=>true,
    'document_root'=>'/home/swoole/static/'
]);

//可以用四种回调
$server->on('open' ,function ($server ,$req) {
    //    var_dump($req);
    echo "server fd:{$req->fd}\n";
});

$server->on('message' ,function ($server ,$frame) {
//    foreach($server->con)
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $server->push($frame->fd,"this is zhanghl server");//opcode 默认1 文本
});


$server->on('close',function($server,$fd){

    echo "client {$fd} close\n";
});

$server->start();