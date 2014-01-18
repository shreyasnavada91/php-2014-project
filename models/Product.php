<?php
class Product {
    private $db;
    public function __construct() { $this->db = DatabaseConfig::getInstance()->getConnection(); }
    public function getAll() {
        $result = $this->db->query("SELECT * FROM products");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
