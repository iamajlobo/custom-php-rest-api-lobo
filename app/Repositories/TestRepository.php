<?php
namespace App\Repositories;
use App\Models\Test;
use Core\Database;
use PDO;

class TestRepository extends BaseRepository {
    protected string $table = 'test';

    public function findByEmail(string $email) : bool
    {
        $sql = "SELECT * FROM $this->table WHERE email=?;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if(is_bool($result)) return false;
        return ($result['email'] === $email);
    }
}
