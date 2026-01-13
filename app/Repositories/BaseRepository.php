<?php
namespace App\Repositories;
use App\Models\Test;
use Core\Database;
use PDO;

class BaseRepository {
    protected PDO $pdo;
    protected string $table = '';
    public function __construct()
    {
        $this->pdo = Database::getInstance()->connect();
    }

    public function create(array $data) : ?int
    {
        $column = implode(',',array_keys($data));
        $row = implode(',',array_fill(0,count($data),'?'));
        $sql = "INSERT INTO {$this->table} ({$column}) VALUES ($row);";
        $stmt = $this->pdo->prepare($sql);
        $success = $stmt->execute(array_values($data));
        return ($success)? $this->pdo->lastInsertId() : null;
    }

    public function read() : array
    {
        $stmt = $this->pdo->query("SELECT * FROM $this->table;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}