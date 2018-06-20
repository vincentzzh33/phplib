<?php
/**
 * Created by Vincent ZHANG.
 * Date: 2018-04-18 0018
 * Time: 14:00
 * Description:
 */

$host = "0.0.0.0";
$port = 8811;
$http = new swoole_http_server($host,$port);

$http->set([
    'enable_static_handler'=>true,
    'document_root'=>'/home/swoole/static/'
]);

$http->on('request',function($req,$res){
    var_dump($req);

    $content = [
        'date:'=>date(DATE_ISO8601),
        'get:'=>$req->get,
        'post:'=>$req->post,
        'header:'=>$req->header,
    ];

    swoole_async_writefile(__DIR__ . "/access.log" ,json_encode($content,JSON_UNESCAPED_UNICODE+JSON_UNESCAPED_SLASHES) ,function ($filename) {
        //todo
        echo 'log success' . PHP_EOL;
    },FILE_APPEND);

    $res->cookie("test","ssss",time()+1800);
    $res->end('<h1>ok</h1>'.json_encode($req->get));
});

$http->start();