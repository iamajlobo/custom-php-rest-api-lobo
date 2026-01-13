<?php

namespace Config;
class DBConfig {
    private static ?DBConfig $instance = null;
    private array $db_config = [
        'host' => 'localhost',
        'db_name' => 'test_db',
        'username' => 'root',
        'password' => ''
    ];

    public static function getInstance() : DBConfig
    {
        if(self::$instance === null){
            self::$instance = new DBConfig();
        }
        return self::$instance;
    }

    public function get($key) : ?string
    {
        foreach($this->db_config as $k => $v){
            if($k === $key){
                return $this->db_config[$key];
            }
        }
        return null;
    }
}