<?php
namespace App\Models;
use App\Database\Database; use App\Database\ValidatesInput;
class User { use ValidatesInput; private ?int $id; private string $name, $email; private ?string $created_at;
    public function __construct(int $id = null, string $name = '', string $email = '') { $this->id = $id; $this->name = $name; $this->email = $email; $this->created_at = date('Y-m-d H:i:s'); }
    public function save(): bool {
        $db = Database::getInstance(); if ($this->id) { return $db->update('users', array('name' => $this->name, 'email' => $this->email, 'updated_at' => date('Y-m-d H:i:s')), 'id = :id', array(':id' => $this->id)) > 0; }
        else { $data = array('name' => $this->name, 'email' => $this->email, 'created_at' => $this->created_at); return $db->insert('users', $data) > 0; }
    }
    public static function getAll(): array { $db = Database::getInstance(); return $db->select('users'); }
    public static function getById(int $id): ?array { $db = Database::getInstance(); return $db->query("SELECT * FROM users WHERE id = ?", array($id))->fetch() ?: null; }
    public static function delete(int $id): bool { $db = Database::getInstance(); return $db->delete('users', 'id = ?', array($id)) > 0; }
    public function getId(): ?int { return $this->id; } public function getName(): string { return $this->name; } public function getEmail(): string { return $this->email; }
    public function setId(?int $id) { $this->id = $id; } public function setName(string $name) { $this->name = $name; } public function setEmail(string $email) { $this->email = $email; }
}
?>