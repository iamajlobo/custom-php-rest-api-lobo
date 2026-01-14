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

    public function update($id,array $data) : bool
    {
        $column = array_map(fn($value,$key) => $key . "=?",$data,array_keys($data));
        $column = implode(',',$column);
        $sql = "UPDATE {$this->table} SET {$column} WHERE id = ?;";
        $data['id'] = $id;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));
        $affected_rows = $stmt->rowCount();
        return $affected_rows > 0 ? true : false;
    }

    public function delete($id) : bool
    {
        $sql = "DELETE FROM $this->table WHERE id=?;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $affected_rows = $stmt->rowCount();
        return $affected_rows > 0 ? true : false;
    }
    
    public function findById($id)
    {   
        $sql = "SELECT * FROM $this->table WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}