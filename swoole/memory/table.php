<?php
/**
 * Created by Vincent ZHANG.
 * Date: 2018-04-19 0019
 * Time: 12:33
 * Description:使用场景,共享一分数据,10个进程共享
 */

$table = new swoole_table(1024);

//内存表
$table->column('id',$table::TYPE_INT,4);
$table->column('name',$table::TYPE_STRING,64);
$table->column('age',$table::TYPE_INT,3);
$table->create();

$table->set('test',[
    'id'=>1,
    'name'=>'signa',
    'age'=>30
]);

//另一种保存方法
//$table['test2']=[]

$table->incr('test','age',2);
$table->decr('test','age',2);

//$table->del('')
print_r($table->get('test'));