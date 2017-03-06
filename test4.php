<?php

//节点结构
class node{
    public $val;
    public $left = NULL;
    public $right = NULL;
}

//深度优先遍历：前序遍历，中序遍历，后序遍历

//前序遍历（递归）
function preOrder1(node $node){
    if(!is_null($node)){
        echo $node -> val;
        $function = __FUNCTION__;
        $function($node -> left);
        $function($node -> right);
    }
}

//前序遍历（非递归）
function preOrder2(node $node){
    if(is_null($node)){
        return;
    }
    // $stack = new SplStack();
    // $stack -> push($node);
    // while(!$stack -> isEmpty()){
    //     $node = $stack -> pop();
    //     echo $node -> val;
    //     if(!is_null($node -> right)){
    //         $stack -> push($node -> right);
    //     }
    //     if(!is_null($node -> left)){
    //         $stack -> push($node -> left);
    //     }
    // }

    $stack = new SplStack();
    while(!is_null($node) || !$stack -> isEmpty()){
        while(!is_null($node)){
            //只要节点不为空就应该入栈保存，与其左右子节点无关
            $stack -> push($node);
            echo $node -> val;
            $node = $node -> left;
        }
        $node = $stack -> pop();
        $node = $node -> right;
    }
}

//中序遍历（递归）
function midOrder1(node $node){
    if(!is_null($node)){
        $function = __FUNCTION__;
        $function($node -> left);
        $function($node -> right);
    }
}

//中序遍历（非递归）
function midOrder2(node $node){
    if(is_null($node)){
        return;
    }
    $stack = new SplStack();
    $stack -> push($node);
    while(!is_null($node) || !$stack -> isEmpty()){
        while(!is_null($node)){
            $stack -> push($node);
            $node = $node -> left;
        }
        $node = $stack -> pop();
        echo $node -> val;
        $node = $node -> right;
    }
}

//后序遍历（递归）
function postOrder1(node $node){
    if(!is_null($node)){
        $function = __FUNCTION__;
        $function($node -> left);
        $function($node -> right);
        echo $node -> val;
    }
}

//后序遍历（非递归）
function postOrder2(node $node){
    if(is_null($node)){
        return;
    }
    $stack = new SplStack();
    //保存上一次访问节点的引用
    $lastVisited = NULL;
    $stack -> push($node);
    while(!$stack -> isEmpty()){
        $node = $stack -> top();    //获取栈顶元素但不弹出
        if((is_null($node -> left) && is_null($node -> right)) || ($lastVisited == $node -> left && is_null($node -> right)) || ($lastVisited == $node -> right)){
            echo $node -> val;
            $lastVisited = $node;
            $stack -> pop();
        }else{
            if(!is_null($node -> right)){
                $stack -> push($node -> right);
            }
            if(!is_null($node -> left)){
                $stack -> push($node -> left);
            }
        }
    }
}

//广度优先遍历：层次遍历

//获取树的深度
function getdepth(node $node){
    if(is_null($node)){
        return 0;
    }
    $function = __FUNCTION__;
    $left = $function($node -> left);
    $right = $function($node -> right);
    $depth = ($left > $right ? $left:$right) + 1;
    return $depth;
}

//层次遍历，按层遍历，需要使用循环(从第一层开始到树的总层数)
function levelOrder1(node $node,$level){
    if(is_null($root) || $level < 1){
        return;
    }
    if($level == 1){
        echo $node -> val;
        return;
    }
    $function = __FUNCTION__;
    if(!is_null($node -> left)){
        $function($node -> left,$level - 1);
    }
    if(!is_null($node -> right)){
        $function($node -> right,$level - 1);
    }
}

//层次遍历（非递归）
function levelOrder2(node $node){
    if(is_null($root)){
        return;
    }
    $queue = new SplQueue();
    $queue -> enqueue($node);
    while(!$queue -> isEmpty()){
        $node = $queue -> dequeue();
        echo $node -> val;
        if(!is_null($node -> left)){
            $queue -> enqueue($node -> left);
        }
        if(!is_null($node -> right)){
            $queue -> enqueue($node -> right);
        }
    }
}
