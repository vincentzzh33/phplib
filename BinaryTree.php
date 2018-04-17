<?php
/**
 * Class BinaryTree
 * @package core\algo
 * 二分搜索树
 * 可以被继承,修改部分方法
 */
class BinaryTree
{
    public $root  = null;
    public $count = 0;//有多少节点

    //直接传一个node对象
    public function insert($node) {
        $newNode = $node;
        if ($this->root == null) {
            $this->root = $newNode;
            $this->count++;
        } else {
            $this->_insertNode($this->root ,$newNode);
        }
    }

    protected function _insertNode($node ,$newNode) {
        if ($newNode->value < $node->value) {
            if ($node->left == null) {
                $node->left = $newNode;
                $this->count++;
            } else {
                $this->_insertNode($node->left ,$newNode);
            }
        } elseif ($newNode->value > $node->value) {//$newNode->value > $node->value
            if ($node->right == null) {
                $node->right = $newNode;
                $this->count++;
            } else {
                $this->_insertNode($node->right ,$newNode);
            }
        } else {
            $node->count++;//如果相同就在这个节点上计数,可以马上查出这个数字出现了几次
        }
    }

    public function inOrder($function) {//中序遍历
        $this->_inOrder($this->root ,$function);
    }

    protected function _inOrder($node ,$function) {
        if ($node != null) {
            $this->_inOrder($node->left ,$function);
            $function($node);
            $this->_inOrder($node->right ,$function);
        }
    }

    public function preOrder($function) {//前序遍历
        $this->_preOrder($this->root ,$function);
    }

    protected function _preOrder($node ,$function) {
        if ($node != null) {
            $function($node);
            $this->_preOrder($node->left ,$function);
            $this->_preOrder($node->right ,$function);
        }
    }

    public function postOrder($function) {//后序
        $this->_postOrder($this->root ,$function);
    }

    protected function _postOrder($node ,$function) {
        if ($node != null) {
            $this->_postOrder($node->left ,$function);
            $this->_postOrder($node->right ,$function);
            $function($node);
        }
    }

    /**
     * @param bool $needNode 只要这个节点的值
     * @return null
     */
    public function min($needNode = false) {
        $node = $this->root;
        while (true) {
            if ($node->left != null) {
                $node = $node->left;
            } else {
                break;
            }
        }
        if ($needNode) {
            return $node;
        } else {
            return $node->value;//只要这个节点的值
        }
    }

    public function max($needNode = false) {
        $node = $this->root;
        while ($node->right != null) {
            $node = $node->right;
        }
        if ($needNode) {
            return $node;
        } else {
            return $node->value;
        }
    }

    public function levelOrder($function) {//深度优先
        $arr[] = $this->root;
        while (!empty($arr)) {
            $node = array_shift($arr);
            $function($node);
            if ($node->left != null) array_push($arr ,$node->left);
            if ($node->right != null) array_push($arr ,$node->right);
        }
    }

    public function depth() {   //深度
        return $this->_depth($this->root);
    }

    protected function _depth($node) {
        if ($node == null) return 0;
        $left = $this->_depth($node->left);
        $right = $this->_depth($node->right);
        return $left > $right ? $left + 1 : $right + 1;
    }

    /**
     * @param $value
     * @return bool 查找是否有这个值
     */
    public function search($value) {
        $node = $this->root;
        while ($node != null) {
            if ($value < $node->value) {
                $node = $node->left;
            } elseif ($value > $node->value) {
                $node = $node->right;
            } else {
                return true;
            }
        }
        return false;
    }

    public function remove($value) {//删除节点
        $this->root = $this->_remove($this->root ,$value);
    }

    protected function _remove($node ,$value) {
        if ($node == null) return null;
        //3种情况
        if ($value < $node->value) {
            $node->left = $this->_remove($node->left ,$value);
            return $node;
        } elseif ($value > $node->value) {
            $node->right = $this->_remove($node->right ,$value);
            return $node;
        } else {//找到节点
            if ($node->left == null && $node->right == null) {
                $node = null;
                return $node;
            }
            if ($node->right == null) {
                $node = $node->left;
                return $node;
            } elseif ($node->left == null) {
                $node = $node->right;
                return $node;
            }
            //两边有节点
            $aux = $this->_findMinNode($node->right);
            $node->value = $aux->value;
            $node->right = $this->_remove($node->right ,$aux->value);
            return $node;
        }
    }

    protected function _findMinNode($node) {
        while ($node && $node->left != null) {
            $node = $node->left;
        }
        return $node;
    }
}