<?php
class order_handle{
    public $conn = NULL;
    public function __construct(){
        try{
            $dir = dirname(__FILE__);
            require_once($dir.'/pdo.php');
            $this->conn = PDO_MYSQL::getInstance()->connect();
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
    public function buy($price,$user_id,$goods_id,$sku_id,$number,$order_sn){
        try{
            //生成订单
            $sql="INSERT INTO ih_order(order_sn,user_id,goods_id,sku_id,price) VALUES(?,?,?,?,?)";
            $ret = $this->conn->prepare($sql);
            if(!$ret->execute(array($order_sn,$user_id,$goods_id,$sku_id,$price))){
                throw new Exception("生成订单失败！");
            }

            //库存减少
            $sql="UPDATE ih_store SET number=number-? WHERE sku_id=? AND number>0";
            $ret = $this->conn->prepare($sql);
            if(!$ret->execute(array($number,$sku_id))){
                throw new Exception("减少库存失败！");
            }
            return true;
        }catch(Exception $e){
            return false;
        }
    }
}
