<?php

class DbConnect {

    private $host   = 'localhost';
    private $db     = 'guestbook';
    
    private $db_user = 'root';
    private $dp_pass = '';
    
    public function dbConnect() {

        try {
            $pdo_conn = new PDO("mysql:dbname=$this->db;host=$this->host", $this->db_user, $this->db_pass,
                           array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                           
            $pdo_conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $pdo_conn;
        } catch (PDOException $e) {
            die('ERROR: '. $e->getMessage());
        }
    }
    
    public function dbClose() {
    }
}

?>