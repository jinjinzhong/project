<?php

class PDO_MYSQL{
    private static $_instance;
    private $_connect;

    private function __construct(){}
    private function __clone(){}

    public static function getInstance(){
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function connect(){
        if(is_null($this->_connect)){
            $dsn = "mysql:host=127.0.0.1;dbname=test";
            $this->_connect = new PDO($dsn,'test','test');
            $this->_connect->exec("SET NAMES utf8");
        }
        return $this->_connect;
    }
}
