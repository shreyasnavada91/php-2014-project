<?php // User with MySQLi
class User {
    private $id, $name, $email;
    public function save() { $db = Database::getInstance(); }
}
?>