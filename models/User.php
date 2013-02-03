<?php
require_once 'config/database.php';
class User {
    private $id, $name, $email, $created_at;
    public function __construct($id = null, $name = null, $email = null) { $this->id = $id; $this->name = $name; $this->email = $email; $this->created_at = date('Y-m-d H:i:s'); }
    public function save() {
        $db = Database::getInstance();
        if ($this->id) { return $db->update('users', array('name' => $this->name, 'email' => $this->email), 'id = :id', array(':id' => $this->id)); }
        else { $data = array('name' => $this->name, 'email' => $this->email, 'created_at' => $this->created_at); return $db->insert('users', $data); }
    }
    public static function getAll() { $db = Database::getInstance(); return $db->select('users'); }
    public static function getById($id) { $db = Database::getInstance(); return $db->query("SELECT * FROM users WHERE id = ?", array($id))->fetch(); }
    public static function delete($id) { $db = Database::getInstance(); return $db->delete('users', 'id = ?', array($id)); }
    public function getId() { return $this->id; } public function getName() { return $this->name; } public function getEmail() { return $this->email; }
    public function setId($id) { $this->id = $id; } public function setName($name) { $this->name = $name; } public function setEmail($email) { $this->email = $email; }
}
?>