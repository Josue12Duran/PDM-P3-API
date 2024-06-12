<?php

class DB {
    private $host = 'localhost';
    private $user = 'id22309351_root';
    private $pass = 'Api_DC20026';
    private $dbname = 'id22309351_casa_top';

    public function connect() {
        $mysql_connect_str = "mysql:host=$this->host;dbname=$this->dbname";
        $dbConnection = new PDO($mysql_connect_str, $this->user, $this->pass);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $dbConnection;
    }
}