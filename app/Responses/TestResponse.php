<?php
namespace App\Responses;
use Core\Response;
class TestResponse {
    public function __construct(private Response $response){}

    public function success(string $message,int $status_code = 200,array $data = []) : void
    {
        $this->response->setStatusCode($status_code)->json([
            'status' => 'success',
            'message' => $message,
            'code'  => $status_code,
            'data' => $data
        ]);
    }

    public function error(string $message, int $status_code, array $error = []) : void
    {
        $this->response->setStatusCode($status_code)->json([
            'status' => 'error',
            'message' => $message,
            'code' => $status_code,
            'error' => $error
        ]);
    }
}