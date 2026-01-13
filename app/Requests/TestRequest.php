<?php
namespace App\Requests;

use Core\Request;

class TestRequest extends Request{
    public function rules() : array
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ];
    }

    public function validated()
    {
        $this->validate($this->rules());
        return $this->only(array_keys($this->rules()));
    }


}