<?php
namespace algo;
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2018-02-20 0020
     * Time: 5:37
     */
//链表节点
class Node
{
    //    public $id; //节点id
    //    public $name; //节点名称
    //    public $next; //下一节点
    //
    //    public function __construct($id, $name) {
    //        $this->id = $id;
    //        $this->name = $name;
    //        $this->next = null;
    //    }

    public $value;
    public $left;
    public $right;
    public $count = 0;

    public function __construct($value) {
        $this->value = $value;
        $this->count = 1;
        $this->left = null;
        $this->right = null;
    }




}
