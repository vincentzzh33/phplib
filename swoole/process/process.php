<?php
/**
 * Created by Vincent ZHANG.
 * Date: 2018-04-19 0019
 * Time: 11:11
 * Description:
 */

$process = new swoole_process(function($pro){
    //todo
    echo 'process 1111'.PHP_EOL;
    //子进程中开户
    $pro->exec("/home/php/bin/php",[__DIR__.'/../server/http_server.php']);

},false);//不打印到屏幕 true 打印 false

$pid = $process->start();

echo $pid.PHP_EOL;
swoole_process::wait();