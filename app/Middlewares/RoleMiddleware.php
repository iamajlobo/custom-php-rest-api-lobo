<?php
namespace App\Middlewares;

class RoleMiddleware extends BaseMiddleware {
    public function handle(array $request)
    {
        if($request['user']['role'] !== 'admin'){
           http_response_code(403);
            echo json_encode([
                'status' => 'forbidden',
                'message' => 'Unauthorized Access is Prohibited!',
                'code' => 403 
            ]);
            exit; 
        }

        return $this->next($request);
    }
}
