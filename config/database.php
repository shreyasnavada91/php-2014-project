<?php
class DatabaseConfig {
    private static $instance = null;
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'ecommerce';
    
    public static function getInstance() {
        if (self::$instance === null) { self::$instance = new self(); }
        return self::$instance;
    }
    
    public function getConnection() {
        return new mysqli($this->host, $this->username, $this->password, $this->database);
    }
}
?>
