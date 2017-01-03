<?php

//数据库链接
$conn = NULL;
try{
    require('./pdo.php');
    $pdo = PDO_MYSQL::getInstance()->connect();
}catch(Exception $e){
    echo $e->getMessage();
}
$conn = $pdo;

//生成唯一订单
function build_order_no(){
    return date('ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

//记录日志
function insertLog($event,$type=0){
    global $conn;
    $sql="insert into ih_log(event,type) values('$event','$type')";
    //没有影响任何一行数据返回0，执行错误返回false
    if($conn->exec($sql) === FALSE){
        throw new Exception("One error occur when Inserting into log");
    }
}

//订单信息
$price=10;
$user_id=1;
$goods_id=1;
$sku_id=11;
$number=1;

//模拟下单操作
//首先检查库存是否大于0
try{
    $sql = "SELECT number FROM ih_store WHERE goods_id=? AND sku_id=? LIMIT 1";
    //解锁 此时ih_store数据中goods_id='$goods_id' and sku_id='$sku_id' 的数据被锁住，
    //其它事务必须等待此次事务 提交后才能执行
    $ret = $conn->prepare($sql);
    $ret->execute(array($goods_id,$sku_id));
    $res = $ret->fetch(PDO::FETCH_ASSOC);

    if($res['number'] > 0){ //这样的话，在高并发的时候会出现超卖现象

        //开启事务(事务优化)
        $conn->beginTransaction();

        $order_sn = build_order_no();
        //生成订单
        $sql="INSERT INTO ih_order(order_sn,user_id,goods_id,sku_id,price) VALUES(?,?,?,?,?)";
        $ret = $conn->prepare($sql);
        if(!$ret->execute(array($order_sn,$user_id,$goods_id,$sku_id,$price))){
            throw new Exception("生成订单失败！");
        }

        //库存减少
        $sql="UPDATE ih_store SET number=number-? WHERE sku_id=? AND number>0";
        $ret = $conn->prepare($sql);
        if(!$ret->execute(array($number,$sku_id))){
            throw new Exception("减少库存失败！");
        }

        //提交事务
        $conn->commit();
    }else{
        echo "库存不足！";
    }
}catch(Exception $e){
    //回滚事务
    $conn->rollBack();
    echo $e->getMessage();
}

?>
