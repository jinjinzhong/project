<?php

//交换方法
function swap(array &$arr,$a,$b){
    $temp = $arr[$a];
    $arr[$a] = $arr[$b];
    $arr[$b] = $temp;
}


//冒泡排序：
function BubbleSort(array &$arr){
    $length = count($arr);

    for($i = 0;$i < $length - 1;$i ++){
        for($j = $length - 2;$j >= $i;$j --){
            if($arr[$j] > $arr[$j + 1]){
                swap($arr,$j,$j + 1);
            }
        }
    }
}

//冒泡排序改进
function BubbleSort1(array &$arr){
    $length = count($arr);
    $flag = true;
    for($i = 0;$i < $length - 1 && $flag;$i ++){
        $flag = false;
        for($j = $length - 2;$j >= $i;$j --){
            if($arr[$j] > $arr[$j + 1]){
                $flag = true;
                swap($arr,$j,$j + 1);
            }
        }
    }
}

//简单选择排序
function SelectSort(array &$arr){
    $length = count($arr);
    for($i = 0;$i < $length - 1;$i ++){
        $min = $i;  //记录最小记录下标
        for($j = $i + 1;$j < $length;$j ++){
            if($arr[$j] < $arr[$min]){
                $min = $j;
            }
        }
        if($min != $i){
            swap($arr,$i,$min);
        }
    }
}

//直接插入排序
function InsertSort(array &$arr){
    $length = count($arr);
    for($i = 1;$i < $length;$i ++){
        $temp = $arr[$i];   //哨兵
        for($j = $i - 1;$j >= 0 && $arr[$j] > $temp;$j --){
            $arr[$j + 1] = $arr[$j];    //记录后移
        }
        $arr[$j + 1] = $temp;   //插入到正确位置
    }
}

//希尔排序
function ShellSort(array &$arr){
    $length = count($arr);
    $inc = $length;  //增量
    do{
        //计算增量
        //$inc = floor($inc / 3) + 1;
        $inc = ceil($inc / 2);
        for($i = $inc;$i < $length;$i ++){
            //设置哨兵
            $temp = $arr[$i];
            for($j = $i - $inc;$j >= 0 && $arr[$j] > $temp;$j -= $inc){
                $arr[$j + $inc] = $arr[$j]; //记录后移
            }
            $arr[$j + $inc] = $temp;
        }
        //增量为1时停止循环
    }while($inc > 1);
}

//堆排序

//调整 $arr[$start]的关键字，使$arr[$start],$arr[$start + 1] .... $arr[$end]成为一个大根堆
//注意，由于这里的数组下标从0开始，因此节点$s左孩子是 2$s + 1，右孩子是 2$s + 2
function HeapAdjust(array $arr,$start,$end){
    $temp = $arr[$start];
    //沿关键字较大的孩子节点向下筛选
    //左右孩子计算（数组下标从0开始）
    //左孩子：2 * $start + 1，右孩子：2 * $start + 2
    for($j = 2 * $start + 1;$j <= $end;$j = 2 * $j + 1){
        if($j != $end && $arr[$j] < $arr[$j + 1]){
            $j ++;  //转化为右孩子
        }
        if($temp >= $arr[$j]){
            break;  //已经是大根堆了
        }
        //将根节点设置为子节点的较大值
        $arr[$start] = $arr[$j];
        //继续往下
        $start = $j;
    }
    $arr[$start] = $temp;
}

function HeapSort(array &$arr){
    $count = count($arr);
    //先将数组构造成大根堆（由于是完全二叉树，这里用floor($count/2)-1,下标小于或等于这数的节点都是非叶子节点）
    for($i = floor($count / 2) - 1;$i >=0;$i --){
        HeapAdjust($arr,$i,$count);
    }
    //开始排序
    for($i = $count - 1;$i >= 0;$i --){
        //将堆顶元素与数组最后一个元素交换，获取到最大元素
        swap($arr,0,$i);
        //经过交换，将最后一个元素脱离大根堆，并将未经排序的新树重新调整为大根堆
        HeapAdjust($arr,0,$i - 1);
    }
}


class Client{
    public static function Main(){
        $arr = array(5,8,2,1,3,4,9,7,6);
        // HeapSort($arr);
        print_r($arr);
    }
}

Client::Main();
