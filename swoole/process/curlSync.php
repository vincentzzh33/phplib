<?php
/**
 * Created by Vincent ZHANG.
 * Date: 2018-04-19 0019
 * Time: 12:24
 * Description:
 */

echo "process start:" . date("Y-m-d H:i:s") . PHP_EOL;
$urls = [
    'http://baidu.com' ,
    'http://sina.com.cn' ,
    'http://qq.com' ,
    'http://baidu.com?search=swoole' ,
    'http://baidu.com?search=python' ,
];

for ($i = 0 ; $i < count($urls) ; $i++) {
    //子进程

    //curl
    $content = curlData($urls[$i]);


    $workers[] = $content;
}


foreach ($workers as $process) {
    echo $process;
}

function curlData($url) {
    sleep(1);
    return $url . "success" . PHP_EOL;
}

echo "process end:" . date("Y-m-d H:i:s") . PHP_EOL;