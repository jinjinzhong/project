<?php
//二分搜索（折半查找）算法（前提是数组必须是有序数组）时间复杂度是O(logn)

$i = 0; //存储对比的次数
//@param 带查找的数组
//@param 带搜索的数字

function binsearch(array $arr,$num){
    $count = count($arr);
    $lower = 0;
    $high = $count - 1;
    global $i;

    while($lower <= $high){

        $i ++;//计数器

        if($num == $arr[$lower]){
            return $lower;
        }
        if($num == $arr[$high]){
            return $high;
        }

        $middle = intval(($lower + $high) / 2);
        if($num < $arr[$middle]){
            $high = $middle - 1;
        }else if($num > $arr[$middle]){
            $lower = $middle + 1;
        }else{
            return $middle;
        }
    }
    return -1;  //表示查找失败
}


//插值查找（前提是数组必须是有序素组）复杂度 O(logn)
//但对于数组长度比较大，关键字分布又是比较均匀的来说，插值查找的效率比折半查找的效率高

//@param 带查找的数组
//@param 带搜索的数字
function insertsearch(array $arr,$num){
     $count = count($arr);
     $lower = 0;
     $high = $count - 1;
     global $i; //计数器
     while($lower <= $high){
        $i ++;
        if($num == $arr[$lower]){
            return $lower;
        }
        if($num == $arr[$high]){
            return $high;
        }
        $middle = intval($lower + ($num - $arr[$lower])/($arr[$high] - $arr[$lower]) * ($high - $lower));
        if($num < $arr[$middle]){
            $high = $middle - 1;
        }else if($num > $arr[$middle]){
            $lower = $middle + 1;
        }else{
            return $middle;
        }
     }
     return -1;
}

$arr = array(0,1,2,2000,2001,2002,2003,2004,5555,69666,99999,100000);
$pos = binsearch($arr,5555);
echo "位置：".$pos;
echo "<br>";
echo "比较次数：".$i;
$i = 0;
echo "<br>";
$pos = insertsearch($arr,5555);
echo "位置：".$pos;
echo "<br>";
echo "比较次数：".$i;
