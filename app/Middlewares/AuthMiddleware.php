<?php
namespace App\Middlewares;

class AuthMiddleware extends BaseMiddleware {
    public function handle(array $request)
    {
        if(!isset($request['user'])){
            http_response_code(401);
            echo json_encode([
                'status' => 'unauthorized',
                'message' => 'Unauthorized Access is Prohibited!',
                'code' => 401 
            ]);
            exit;
        }

        return $this->next($request);
    }
}