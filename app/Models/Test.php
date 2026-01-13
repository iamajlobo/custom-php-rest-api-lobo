<?php
namespace App\Models;

class Test {
    private string $name;
    private string $email;
    private string $password;
    public function __construct(array $data=[]){
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->password = password_hash($data['password'],PASSWORD_DEFAULT) ?? '';
    }

    public function getTest() : array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}