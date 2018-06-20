<?php

/**
 * Created by Vincent ZHANG.
 * Date: 2018-04-18 0018
 * Time: 15:32
 * Description:
 */
class Ws
{

    const HOST = "0.0.0.0";
    const PORT = 8812;

    public function __construct() {
        $this->ws = new swoole_websocket_server(self::HOST ,self::PORT);

        $this->ws->set([
            'worker_num' => 2 ,
            'task_worker_num' => 2 ,
        ]);
        $this->ws->on("open" ,[$this ,'onOpen']);
        $this->ws->on("message" ,[$this ,'onMessage']);
        $this->ws->on("task" ,[$this ,'onTask']);
        $this->ws->on("finish" ,[$this ,'onFinish']);
        $this->ws->on("close" ,[$this ,'onClose']);

        $this->ws->start();
    }

    /**
     * 监听ws连接事件
     * @param $ws
     * @param $req
     */
    public function onOpen($ws ,$req) {
        var_dump($req->fd);//客户端标识id

        //定时任务
        if($req->fd==100){
           swoole_timer_tick(2000,function($timer_id){
               echo "2s:timerid:{$timer_id}\n";
           });
        }
    }

    public function onMessage($ws ,$frame) {
        echo "$frame->fd :{$frame->data}\n";//打印输出在服务器控制台
        //这里要10秒
        //投放异步任务
        $data = [
            'task' => 1 ,
            'fd' => $frame->fd ,
        ];
//        $ws->task($data);//启动任务

        //异步任务
        swoole_timer_after(5000,function() use($ws,$frame){
            $ws->push($frame->fd, "server push 5s after");
        });

        $ws->push($frame->fd ,"server time:" . date("Y-m-d H:i:s"));
    }

    public function onClose($ws ,$fd) {
        echo "client {$fd} close\n";

    }

    public function onTask($serv ,$task_id ,$src_worker_id ,$data) {
        print_r($data);
        sleep(5);
        return "on task finish";// 告诉work
    }

    public function onFinish($serv ,$taskId ,$data) {
        echo "taskid:{$taskId}\n";
        echo "finish:{$data}\n";//这个是ontask 中return的
    }
}

$obj = new Ws();