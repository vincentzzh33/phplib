<?php
/**
 * Created by Vincent ZHANG.
 * Date: 2018-04-19 0019
 * Time: 12:52
 * Description:协程无感知识现异步
 */




$host = "0.0.0.0";
$port = 8001;
$http = new swoole_http_server($host,$port);


$http->on('request',function($req,$res){
    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('127.0.01',7200);
    $value = $redis->get($req->get['aa']);

    //mysql...

    //time = max ( redis,mysql)

    $res->header("Content-Type","text/plain");
    $res->end($value);
});


$http->start();