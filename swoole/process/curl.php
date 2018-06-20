<?php
/**
 * Created by Vincent ZHANG.
 * Date: 2018-04-19 0019
 * Time: 12:14
 * Description:
 */
echo "process start:".date("Y-m-d H:i:s").PHP_EOL;
$urls = [
    'http://baidu.com' ,
    'http://sina.com.cn' ,
    'http://qq.com' ,
    'http://baidu.com?search=swoole' ,
    'http://baidu.com?search=python' ,
];

for ($i = 0 ; $i < count($urls) ; $i++) {
    //子进程
    $process = new swoole_process(function () use ($i ,$urls) {

        //curl
        $content = curlData($urls[$i]);
        echo $content . PHP_EOL;

    } ,true);//true不打印,放到管道里

    $pid = $process->start();
    $workers[$pid] = $process;
}


foreach($workers as $process){
    echo $process->read();
}

function curlData($url) {
    sleep(1);
    return $url . "success" . PHP_EOL;
}

echo "process end:".date("Y-m-d H:i:s").PHP_EOL;