<?php
namespace App\Database;
use PDO; use PDOException;
class Database {
    private static ?PDO $instance = null; private static ?self $singleton = null;
    private PDO $connection; private string $host, $dbname, $username, $password, $charset;
    private function __construct() {
        $this->host = 'localhost'; $this->dbname = 'company_db'; $this->username = 'root'; $this->password = 'password'; $this->charset = 'utf8';
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $this->connection = new PDO($dsn, $this->username, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_PERSISTENT => true));
        } catch (PDOException $e) { error_log("Database connection failed: " . $e->getMessage()); throw new RuntimeException("Database connection failed"); }
    }
    public static function getInstance(): self { if (self::$singleton === null) { self::$singleton = new self(); } return self::$singleton; }
    public function getConnection(): PDO { return $this->connection; }
    public function query(string $sql, array $parameters = []): PDOStatement { $stmt = $this->connection->prepare($sql); $stmt->execute($parameters); return $stmt; }
    public function select(string $table, array $columns = ['*'], string $where = '', array $params = []): array { $columnsStr = implode(', ', $columns); $sql = "SELECT {$columnsStr} FROM {$table}"; if ($where) { $sql .= " WHERE {$where"; } $stmt = $this->query($sql, $params); return $stmt->fetchAll(); }
    public function insert(string $table, array $data): int { $columns = implode(', ', array_keys($data)); $placeholders = ':' . implode(', :', array_keys($data)); $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})"; $stmt = $this->query($sql, $data); return (int)$this->connection->lastInsertId(); }
    public function update(string $table, array $data, string $where, array $whereParams = []): int { $sets = []; foreach (array_keys($data) as $column) { $sets[] = "{$column} = :{$column}"; } $sql = "UPDATE {$table} SET " . implode(', ', $sets) . " WHERE {$where}"; $stmt = $this->query($sql, array_merge($data, $whereParams)); return $stmt->rowCount(); }
    public function delete(string $table, string $where, array $params = []): int { $sql = "DELETE FROM {$table} WHERE {$where}"; $stmt = $this->query($sql, $params); return $stmt->rowCount(); }
}
trait ValidatesInput { protected array $errors = []; protected function validateRequired(string $field, string $value): bool { if (empty(trim($value))) { $this->errors[$field] = ucfirst($field) . ' is required'; return false; } return true; } public function getErrors(): array { return $this->errors; } public function hasErrors(): bool { return !empty($this->errors); } }
?>