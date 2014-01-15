<?php
/**
 * PHP Application - 2014 Era
 * 
 * Features:
 * - MVC pattern
 * - MySQLi database
 * - jQuery frontend
 * - Bootstrap 3 design
 */

// Database configuration - 2014 style
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ecommerce');

// MySQLi connection - 2014 preferred over mysql_*
$Connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($Connection->connect_error) {
    die("Connection failed: " . $Connection->connect_error);
}

// Simple controller pattern - 2014 style
class ProductController {
    private $db;
    
    public function __construct() {
        $this->db = DatabaseManager::getInstance()->getConnection();
    }
    
    public function index() {
        $result = $this->db->query("SELECT * FROM products LIMIT 10");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function get($id) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}

// Database manager - singleton pattern (2014 common)
class DatabaseManager {
    private static $instance = null;
    private $Connection;
    
    private function __construct() {
        $this->Connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->Connection;
    }
}

// Usage - 2014 style
$controller = new ProductController();
$products = $controller->index();

// Output JSON - 2014 style (no json_encode for everything yet, but using it here)
header('Content-Type: application/json');
echo json_encode($products);
?>
