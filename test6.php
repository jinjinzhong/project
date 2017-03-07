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
function HeapAdjust(array &$arr,$start,$end){
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

//基数排序（最低位优先）

//获取需要循环的次数
function getLoopTimes(array $arr){
    //首先是获取数组中的最大值，最大值的位数就是循环的次数
    $max = 0;
    $length = count($arr);
    for($i = 0;$i < $length;$i ++){
        if($max < $arr[$i]){
            $max = $arr[$i];
        }
    }

    //根据最大值获取循环次数
    $count = 1; //假设只有个位，则只需要循环一次
    $temp = floor($max / 10);
    while($temp != 0){
        $count ++;
        $temp = floor($temp / 10);
    }
    return $count;
}

//@param $arr 数组
//@param $loop 第几次循环标示
//该函数只是完成某一位（个、十、百、、）上的通排序
function R_sort(array &$arr,$loop){
    //桶数组，强类型语言中，该数组应该声明为[10][count($arr)]
    //第一维是 0-9 十个数
    //第二维这样定义是因为有可能待排序的数组中的所有数的某一位上都是一样的，这样就全挤在一个桶中了
    $tempArr = array();
    $length = count($arr);

    //初始化桶数组
    for($i = 0;$i < 10;$i ++){
        $tempArr[$i] = array();
    }

    //求桶的index的除数
    //如 798 个位桶 index = (798 / 1) % 10
    //十位桶 index = (798 / 10) % 10
    //百位桶 index = (798 / 100) % 10
    //$tempNum就是上面中的 1\10\100
    $tempNum = (int)pow(10,$loop - 1);
    for($i = 0;$i < $length;$i ++){
        //求出某位上的数字
        $row_index = floor($arr[$i] / $tempNum) % 10;
        //入桶
        array_push($tempArr[$row_index],$arr[$i]);
    }

    //还原回原来的数组中
    $k = 0;
    for($i = 0;$i < 10;$i ++){
        //出桶
        while(!empty($tempArr[$i])){
            $arr[$k ++] = array_shift($tempArr[$i]);
        }
    }
}

//最终调用的主函数
function RadixSort(array &$arr){
    $loopTimes = getLoopTimes($arr);
    //对每一位进行桶分配（1表示个位，$loop表示最高位）
    for($i = 1;$i <= $loopTimes;$i ++){
        R_sort($arr,$i);
    }
}

//快速排序

//选取数组中的一个关键字，使得它处于数组某个位置时，左边的值都比它小，右边的值都比它大，该关键字叫做枢轴
//使枢轴记录到位，并返回起所在位置
function Partition(array &$arr,$low,$high){
    $pivot = $arr[$low];    //选取数组中的第一个元素作为枢轴
    while($low < $high){    //从数组的两端交替向中间扫描（当$low和$high碰头时结束循环）
        while($low < $high && $arr[$high] >= $pivot){
            $high --;
        }
        swap($arr,$low,$high);  //终于遇到一个比 $pivot 小的数，将其放到数组低端
        while($low < $high && $arr[$low] <= $pivot){
            $low ++;
        }
        swap($arr,$low,$high);  //终于遇到一个比 $pivot 大的数，将其放到数组高端
    }
    return $low;    //返回$high也行，毕竟最最后$low和$high都是停留在$pivot下标处
}

function QSort(array &$arr,$low,$high){
    //当$low >= $high 时表示不能再进行分组，已经能够得出正确结果了
    if($low < $high){
        $pivot = Partition($arr,$low,$high);    //将$arr[$low .... $high]一分为二，算出枢轴
        QSort($arr,$low,$pivot - 1);    //对低子表进行递归排序
        QSort($arr,$pivot + 1,$high);   //对高子表进行递归排序
    }
}

function QuickSort(array &$arr){
    $low = 0;
    $high = count($arr) - 1;
    QSort($arr,$low,$high);
}

//归并排序

//归并操作（将两个子数组归并成一个有序的大数组）
function Merge(array &$arr,$start,$mid,$end){
    $i = $start;
    $j = $mid + 1;
    $k = $start;
    $tempArr = array();

    while($i <= $mid && $j <= $end){
        if($arr[$i] <= $arr[$j]){
            $tempArr[$k ++] = $arr[$i ++];
        }else{
            $tempArr[$k ++] = $arr[$j ++];
        }
    }

    //将第一个子序列的剩余部分添加到已经排好序的 $tempArr 数组中
    while($i <= $mid){
        $tempArr[$k ++] = $arr[$i ++];
    }
    while($j <= $end){
        $tempArr[$k ++] = $arr[$j ++];
    }
    //还原回原数组
    for($i = $start;$i <= $end;$i ++){
        $arr[$i] = $tempArr[$i];
    }
}

function MSort(array &$arr,$start,$end){
    //当子序列长度为1时，$start == $end,不用再分组
    if($start < $end){
        $mid = floor(($start + $end) / 2);  //将 $arr 平分为 $arr[$start -- $mid] $arr[$mid+1 -- $end]
        MSort($arr,$start,$mid);
        MSort($arr,$mid + 1,$end);
        Merge($arr,$start,$mid,$end);   //合并
    }
}

//归并排序总函数
function MergeSort(array &$arr){
    $start = 0;
    $end = count($arr) - 1;
    MSort($arr,$start,$end);
}


class Client{
    public static function Main(){
        $arr = array(3,4,9,7,6,5,8,2,1);
        MergeSort($arr);
        print_r($arr);
    }
}

Client::Main();
