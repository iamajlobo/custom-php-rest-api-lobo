<?php

namespace App\Middlewares;

class TestMiddleware {
    public function handle($request){
        if(!isset($request['user'])){
            http_response_code(401);
            echo json_encode([
                'status' => 'unauthorized',
                'message' => 'Unauthorized Access is Prohibited!',
                'code' => 401 
            ]);
            exit;
        }
    }
}