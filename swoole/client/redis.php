<?php
/**
 * Created by Vincent ZHANG.
 * Date: 2018-04-20 0020
 * Time: 15:40
 * Description:
 */
class Predis
{

    public         $redis     = "";
    private static $_instance = null;
    const HOST = '127.0.0.1';
    const PORT = 6382;

    private function __construct() {
        $this->redis = new \Redis();
        $res = $this->redis->connect(self::HOST ,self::PORT);
//        var_dump($this->redis);
        //这里加try
        if ($res === false) {
            throw new \Exception('redis connect error');
        }
    }

    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function set($key ,$value ,$time = 0) {

        if (!$key) {
            return '';
        }

        if (is_array($value)) {
            $value = json_encode($value);
        }

        if (!$time) {
            return $this->redis->set($key ,$value);
        }

        return $this->redis->setex($key ,$time ,$value);
    }

    public function get($key) {
        if (!$key) {
            return '';
        }
        return $this->redis->get($key);
    }

    public function mget($array) {
        $this->redis->mget($array);
    }
}

$redis = Predis::getInstance();
echo $redis->get('aa').PHP_EOL;
$red = new Redis();