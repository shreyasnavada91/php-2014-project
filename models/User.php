<?php
require_once 'config/database.php';
class User {
    private $id, $name, $email;
    public function __construct($id = null, $name = null, $email = null) { $this->id = $id; $this->name = $name; $this->email = $email; }
    public function save() {
        $db = Database::getInstance(); $stmt = $db->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $this->name, $this->email); return $stmt->execute();
    }
    public static function getAll() {
        $db = Database::getInstance(); $result = $db->query("SELECT * FROM users");
        $users = array(); while ($row = $result->fetch_assoc()) { $users[] = $row; }
        return $users;
    }
    public function getId() { return $this->id; } public function getName() { return $this->name; } public function getEmail() { return $this->email; }
    public function setId($id) { $this->id = $id; } public function setName($name) { $this->name = $name; } public function setEmail($email) { $this->email = $email; }
}
?>