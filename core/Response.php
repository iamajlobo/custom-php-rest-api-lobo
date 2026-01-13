<?php

namespace Core;

class Response {
    private array $headers = [];
    private int $status_code = 200;

    public function setStatusCode(int $code) : self
    {
        $this->status_code = $code;
        return $this;
    }

    public function setHeader($key,$value) : self
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function redirect(string $path = '/') : void
    {
        header("Location: $path");
    }

    public function json(array $data) : void
    {
        http_response_code($this->status_code);
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($data,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    public function getHeaders() {
        foreach($this->headers as $key => $value){
            header("$key: $value");
        }
    }
}