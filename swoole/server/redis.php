<?php
/**
 * Created by Vincent ZHANG.
 * Date: 2018-04-19 0019
 * Time: 10:03
 * Description:
 */
$redisClient = new swoole_redis;//Swoole\Redis
$redisClient->connect('127.0.0.1' ,26379 ,function ($redisClient ,$result) {
    echo "connect:" . PHP_EOL;
    var_dump($result);

    $redisClient->set('sssss',time(),function($redisClient ,$result){
        echo "sssss:" . PHP_EOL;
        var_dump($result);
    });

    $redisClient->get('aa',function($redisClient ,$result){
        echo "aa:" . PHP_EOL;
        var_dump($result);//返回的值

    });

    $redisClient->close();

});

echo 'start:'.PHP_EOL;