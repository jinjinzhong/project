<?php

class myRedis{
    private static $_instance;
    private $_redis;

    private function __construct(){

    }
    private function __clone(){

    }

    public static function getInstance(){
        if(!(self::$_instance instanceof redis)){
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function connect(){
        if(is_null($this->_redis)){
            $this->_redis = new redis();
            $this->_redis->connect('127.0.0.1',6379);
        }
        return $this->_redis;
    }
}
