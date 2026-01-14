<?php
namespace Core;
use PDO;
use Config\DBConfig;
class Database {
    private static ?Database $instance = null;
    private PDO $pdo; 
    private DBConfig $db_config;
    
    public function __construct()
    {
        $this->db_config = new DBConfig();
        $this->pdo = new PDO (
            "mysql:host={$this->db_config->get('host')};dbname={$this->db_config->get('db_name')};",$this->db_config->get('username'),$this->db_config->get('password')
        );
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES,false);
    }
    
    public static function getInstance() : Database
    {
        if(self::$instance === null){
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function connect() : PDO
    {
        return $this->pdo;
    }
}