<?php

class DB {
    private $host = 'localhost:33060';
    private $user = 'root';
    private $pass = '0000';
    private $dbname = 'casa_top';

    public function connect() {
        $mysql_connect_str = "mysql:host=$this->host;dbname=$this->dbname";
        $dbConnection = new PDO($mysql_connect_str, $this->user, $this->pass);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $dbConnection;
    }
}