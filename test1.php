<?php

require_once('./redis.php');

$redis = myRedis::getInstance()->connect();

//生成唯一订单
function build_order_no(){
    return date('ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

//订单信息
$price=10;
$user_id=1;
$goods_id=1;
$sku_id=11;
$number=1;
$order_sn = build_order_no();

$order_info = array(
    'price'     =>  $price,
    'user_id'   =>  $user_id,
    'goods_id'  =>  $goods_id,
    'sku_id'    =>  $sku_id,
    'number'    =>  $number,
    'order_sn'  =>  $order_sn
);

$order_info = json_encode($order_info);

$redis->lpush('order_lists',$order_info);
$redis->close();
