<?php

/**
 * Created by Vincent ZHANG.
 * Date: 2018-04-18 0018
 * Time: 17:09
 * Description:
 */
class Asysql
{
    public $dbSource = "";

    public function __construct() {

        $this->dbSource = new Swoole\Mysql;
        $this->dbConfig = [
            'host' => '192.168.253.10' ,
            'port' => 3306 ,
            'user' => 'root' ,
            'password' => 'Zhl@12345678' ,
            'database' => 'test' ,
            'charset' => 'utf8'
        ];
    }

    public function update() {

    }

    public function add() {


    }

    public function execute($id ,$username) {
        $this->dbSource->connect($this->dbConfig ,function ($db ,$res) {
            echo 'mysql-connect'.PHP_EOL;
            if ($res===false) {
                var_dump($db->connect_error);
                return;
            }

//            $sql = "select * from news";
            $sql = "update news set title='".uniqid()."' where id =12";
            $db->query($sql ,function ($db ,$result) {
                if($result===false){

                }elseif($result===true){
                    //add update delete
                    var_dump($db->affected_rows);
                }else{
                    var_dump($result);
                }

                $db->close();

            });
        });
        return ['adfdafd'=>'ddafas'];//这里返回的
    }
}

$obj = new Asysql();
$flag = $obj->execute(1 ,'tsteasea');//不关心这里的操作,不影响后面的逻辑
var_dump($flag);//true               //这里直接返回
echo 'start:'.PHP_EOL;

//业务场景:
//详情页->mysql(阅读书)->mysql文章+1->页面数据呈现