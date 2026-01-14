<?php
namespace Core;

class Request {
    protected array $data = [];

    public function __construct()
    {
        $raw = file_get_contents('php://input');
        $this->data = json_decode($raw,true) ?? [];
    }

    public function method() : string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function path() : string
    {
        return parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
    }

    public function body() : array
    {
        return $this->data;
    }

    public function user() : array
    {
        return ['users'=>$this->data];
    }

    public function only(array $keys) : array
    {
        return array_intersect_key($this->data,array_flip($keys));
    }

    public function validate(array $rules) : void
    {
        $errors = [];

        foreach($rules as $field => $rule_string){
            $rule_list = explode('|',$rule_string);
            $value = $this->data[$field] ?? null;
            foreach($rule_list as $rule){
                if($rule === 'required' && ($value === null || $value === '')){
                    $errors[$field][] = "This Fields is required!";
                }
    
                if($rule === 'email' && $value !== null && !filter_var($value,FILTER_VALIDATE_EMAIL)){
                    $errors[$field][] = "Invalid Email Format";
                }

                if(str_starts_with($rule, 'min:') && $value !== null){
                    $min = (int) explode(':',$rule)[1];
                    if(strlen($value) < $min){
                        $errors[$field][] = "Minimum length is $min";
                    }
                }
            }
        }
        if(!empty($errors)){
            http_response_code(422);
            echo json_encode([
                'status' => 'error',
                'message' => 'Validation Error',
                'code' => 422,
                'error' => $errors
            ]);
            exit;
        }
    }
}