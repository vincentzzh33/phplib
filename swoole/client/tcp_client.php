<?php
//连接
$client = new swoole_client(SWOOLE_SOCK_TCP);
if(!$client->connect("127.0.0.1",9501)){

    echo '连接失败';
}

//内置cli的常量
fwrite(STDOUT,"请输入消息");
$msg = trim(fgets(STDIN));

//发送给服务器
$client->send($msg);

//接受server来的数据

$result = $client->recv();


echo $result;