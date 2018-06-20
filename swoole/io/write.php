<?php
/**
 * Created by Vincent ZHANG.
 * Date: 2018-04-18 0018
 * Time: 16:43
 * Description:
 */


$content = date(DATE_ISO8601).PHP_EOL;
swoole_async_writefile(__DIR__ . "/1.log" ,$content ,function ($filename) {
    //todo
    echo 'success' . PHP_EOL;
},FILE_APPEND);

//完成 4M以上文件


echo 'start' . PHP_EOL;