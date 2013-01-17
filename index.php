<?php
session_start();
$host = 'localhost';
$username = 'root';
$password = 'password';
$database = 'company_db';
$connection = mysql_connect($host, $username, $password);
mysql_select_db($database, $connection);

class User {
    private $id; private $name; private $email;
    public function __construct($id = null, $name = null, $email = null) {
        $this->id = $id; $this->name = $name; $this->email = $email;
    }
    public function save() {
        $name = mysql_real_escape_string($this->name);
        $email = mysql_real_escape_string($this->email);
        return mysql_query("INSERT INTO users (name, email) VALUES ('$name', '$email')");
    }
    public static function getAll() {
        $result = mysql_query("SELECT * FROM users");
        $users = array();
        while ($row = mysql_fetch_assoc($result)) { $users[] = $row; }
        return $users;
    }
}
require_once 'config/database.php';
require_once 'models/User.php';
echo "PHP 5.3 - Legacy MySQL Extension";
?> <!DOCTYPE html><html><head><title>PHP 2013</title></head><body><h1>User Management</h1></body></html>