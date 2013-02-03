<?php
define('DB_HOST', 'localhost'); define('DB_NAME', 'company_db'); define('DB_USER', 'root'); define('DB_PASS', 'password'); define('DB_CHARSET', 'utf8');
class Database {
    private $pdo; private static $instance = null;
    private function __construct() {
        try {
            $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
        } catch (PDOException $e) { die('Connection failed: ' . $e->getMessage()); }
    }
    public static function getInstance() { if (self::$instance === null) { self::$instance = new Database(); } return self::$instance; }
    public function getConnection() { return $this->pdo; }
    public function query($sql, $params = array()) { $stmt = $this->pdo->prepare($sql); $stmt->execute($params); return $stmt; }
    public function select($table, $where = '', $params = array()) { $sql = "SELECT * FROM " . $table; if ($where) { $sql .= " WHERE " . $where; } $stmt = $this->pdo->prepare($sql); $stmt->execute($params); return $stmt->fetchAll(); }
    public function insert($table, $data) { $columns = implode(', ', array_keys($data)); $placeholders = ':' . implode(', :', array_keys($data)); $sql = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $placeholders . ")"; $stmt = $this->pdo->prepare($sql); return $stmt->execute($data); }
    public function update($table, $data, $where, $whereParams = array()) { $sets = array(); foreach (array_keys($data) as $column) { $sets[] = "$column = :$column"; } $sql = "UPDATE " . $table . " SET " . implode(', ', $sets) . " WHERE " . $where; $stmt = $this->pdo->prepare($sql); return $stmt->execute(array_merge($data, $whereParams)); }
    public function delete($table, $where, $params = array()) { $sql = "DELETE FROM " . $table . " WHERE " . $where; $stmt = $this->pdo->prepare($sql); return $stmt->execute($params); }
}
?>