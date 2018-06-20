<?php
/**
 * Created by Vincent ZHANG.
 * Date: 2018-04-18 0018
 * Time: 16:33
 * Description:
 */

$res = swoole_async_readfile(__DIR__ . "/12.txt" ,function ($filename ,$fileContent) {
    echo "filename:" . $filename . PHP_EOL;
    echo "content" . $fileContent . PHP_EOL;
});

//分段读取,处理较大文件
//$res = swoole_async_read(__DIR__ . "/12.txt" ,function ($filename ,$fileContent) {
//    echo "filename:" . $filename . PHP_EOL;
//    echo "content" . $fileContent . PHP_EOL;
//});

var_dump($res);
echo 'haha:'.PHP_EOL;