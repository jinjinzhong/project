<?php

//本文件在服务器中以命令行的方式运行 nohup php /home/www/site1/test3.php &

$dir = dirname(__FILE__);
require_once($dir.'/redis.php');
require_once($dir.'/test2.php');

set_time_limit(0); // 取消脚本运行时间的超时上限

$order = new order_handle();
$redis = myRedis::getInstance()->connect();

while (true) {
    //返回的列表的大小。如果列表不存在或为空，该命令返回0。如果该键不是列表，该命令返回false
    while($redis -> lsize('order_lists')){
        //从LIST头部删除并返回删除数据
        $order_info = $redis->rpop('order_lists');
        $order_info = json_decode($order_info,TRUE);
        var_dump($order_info);
        $order->buy($order_info['price'],$order_info['user_id'],$order_info['goods_id'],$order_info['sku_id'],$order_info['number'],$order_info['order_sn']);
    }
    sleep(10);//延时10秒
}
$redis->close();
