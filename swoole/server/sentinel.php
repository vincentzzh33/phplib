<?php
/**
 * Created by Vincent ZHANG.
 * Date: 2018-04-23 0023
 * Time: 10:55
 * Description:
 */
/*
    * Send arbitrary things to the redis server.
    * @param   string      $command    Required command to send to the server.
    * @param   mixed       ...$arguments  Optional variable amount of arguments to send to the server.
    * @return  mixed
    * @example
    * <pre>
    * $redis->rawCommand('SET', 'key', 'value'); // bool(true)
    * $redis->rawCommand('GET", 'key'); // string(5) "value"
    * </pre>
    */
//public function rawCommand( $command, $arguments ) {}
//初始化redis对象
$redis = new Redis();
//连接sentinel服务 host为ip，port为端口
$host = '127.0.0.1';
$port = 26379;
$redis->connect($host ,$port);

//可能用到的部分命令，其他可以去官方文档查看

//获取主库列表及其状态信息
$result = $redis->rawCommand('SENTINEL' ,'masters');
var_dump(parseArrayResult($result));
//根据所配置的主库redis名称获取对应的信息
//master_name应该由运维告知（也可以由上一步的信息中获取）
$master_name = $result[0][1];
$result = $redis->rawCommand('SENTINEL' ,'master' ,$master_name);

//根据所配置的主库redis名称获取其对应从库列表及其信息
$result = $redis->rawCommand('SENTINEL' ,'slaves' ,$master_name);
var_dump($result);
//获取特定名称的redis主库地址
$result = $redis->rawCommand('SENTINEL' ,'get-master-addr-by-name' ,$master_name);

//array(1) {
//    [0]=>
//  array(19) {
//        ["name"]=>
//    string(8) "mymaster"
//        ["ip"]=>
//    string(9) "127.0.0.1"
//        ["port"]=>
//    string(4) "7000"
//        ["runid"]=>
//    string(40) "04fe2b27f52e04d6a02997cd6b45690e711789f9"
//        ["flags"]=>
//    string(6) "master"
//        ["pending-commands"]=>
//    string(1) "0"
//        ["last-ping-sent"]=>
//    string(1) "0"
//        ["last-ok-ping-reply"]=>
//    string(3) "809"
//        ["last-ping-reply"]=>
//    string(3) "809"
//        ["down-after-milliseconds"]=>
//    string(5) "30000"
//        ["info-refresh"]=>
//    string(4) "2981"
//        ["role-reported"]=>
//    string(6) "master"
//        ["role-reported-time"]=>
//    string(7) "2021578"
//        ["config-epoch"]=>
//    string(1) "0"
//        ["num-slaves"]=>
//    string(1) "2"
//        ["num-other-sentinels"]=>
//    string(1) "2"
//        ["quorum"]=>
//    string(1) "2"
//        ["failover-timeout"]=>
//    string(6) "180000"
//        ["parallel-syncs"]=>
//    string(1) "1"
//  }
//}

//这个方法可以将以上sentinel返回的信息解析为数组
function parseArrayResult(array $data) {
    $result = array();
    $count = count($data);
    for ($i = 0 ; $i < $count ;) {
        $record = $data[$i];
        if (is_array($record)) {
            $result[] = parseArrayResult($record);
            $i++;
        } else {
            $result[$record] = $data[$i + 1];
            $i += 2;
        }
    }
    return $result;
}