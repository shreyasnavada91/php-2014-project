<?php
$db_config = array('host' => 'localhost', 'username' => 'root', 'password' => 'password', 'database' => 'company_db');
class Database {
    private $mysqli; private static $instance = null;
    private function __construct() {
        $this->mysqli = new mysqli($GLOBALS['db_config']['host'], $GLOBALS['db_config']['username'], $GLOBALS['db_config']['password'], $GLOBALS['db_config']['database']);
        if ($this->mysqli->connect_error) { die('Connection failed: ' . $this->mysqli->connect_error); }
        $this->mysqli->set_charset($GLOBALS['db_config']['charset']);
    }
    public static function getInstance() { if (self::$instance === null) { self::$instance = new Database(); } return self::$instance; }
    public function query($sql) { return $this->mysqli->query($sql); }
    public function prepare($sql) { return $this->mysqli->prepare($sql); }
}
?>